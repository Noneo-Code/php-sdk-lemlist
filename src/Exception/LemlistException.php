<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Exception;

use Saloon\Http\Response;

/**
 * Racine de toutes les erreurs du SDK : `catch (LemlistException)` couvre les
 * réponses en échec, les pannes réseau et les corps inexploitables.
 *
 * L'exception ne retient **aucune** référence à l'objet `Response` de Saloon :
 * depuis lui on remonte à la requête, donc à ses en-têtes, donc au
 * `Authorization: Basic …`. Un `Sentry::captureException()`, un `print_r()` ou
 * une simple trace suffiraient alors à journaliser la clé d'API. Seules les
 * données de diagnostic sont recopiées : statut, en-têtes de réponse filtrés,
 * corps tronqué et champs décodés.
 */
abstract class LemlistException extends \RuntimeException
{
    /**
     * Un 502 rendu par un proxy en amont porte une page HTML qui peut peser
     * des centaines de kilooctets : conservée telle quelle, elle transiterait
     * dans chaque log et chaque événement Sentry.
     */
    protected const int MAX_BODY_LENGTH = 2_000;

    private const int MAX_MESSAGE_LENGTH = 500;

    /**
     * Champs du corps d'erreur qui portent le texte plutôt qu'un détail
     * structuré : ils alimentent le message, pas details().
     */
    private const array TEXT_KEYS = ['error', 'message'];

    /**
     * Allowlist et non denylist : les en-têtes utiles au diagnostic sont
     * connus et peu nombreux, alors qu'un en-tête inattendu peut porter un
     * secret — `Set-Cookie` au premier chef. Comparaison insensible à la
     * casse ; la clé restituée est celle listée ici.
     *
     * @var list<string>
     */
    private const array DIAGNOSTIC_HEADERS = [
        'Retry-After',
        'Content-Type',
        'Date',
        'Location',
        'X-Request-Id',
        'X-RateLimit-Limit',
        'X-RateLimit-Remaining',
        'X-RateLimit-Reset',
    ];

    /**
     * @param array<string, mixed>  $details
     * @param array<string, string> $responseHeaders
     */
    final public function __construct(
        string $error,
        int $status,
        private readonly array $details = [],
        private readonly array $responseHeaders = [],
        private readonly string $responseBody = '',
    ) {
        parent::__construct($error, $status);
    }

    /**
     * `$response` est marquée sensible : elle donne accès à la requête signée.
     * L'attribut retire cette frame des arguments de trace quand l'hôte les
     * conserve.
     *
     * @internal factory du SDK — le consommateur reçoit l'exception, il ne la
     *     construit pas
     */
    public static function fromResponse(#[\SensitiveParameter] Response $response): ?self
    {
        $status = $response->status();
        $body = self::decodeBody($response);
        $arguments = [
            self::truncate(self::extractError($body, $response), self::MAX_MESSAGE_LENGTH),
            $status,
            self::extractDetails($body),
            self::extractHeaders($response),
            self::truncate($response->body(), self::MAX_BODY_LENGTH),
        ];

        return match (true) {
            400 === $status => new BadRequestException(...$arguments),
            401 === $status => new UnauthorizedException(...$arguments),
            403 === $status => new ForbiddenException(...$arguments),
            404 === $status => new NotFoundException(...$arguments),
            409 === $status => new ConflictException(...$arguments),
            422 === $status => new ValidationException(...$arguments),
            429 === $status => new RateLimitException(...$arguments),
            $status >= 500 => new ServerException(...$arguments),
            $status >= 400 => new ClientException(...$arguments),
            $status >= 300 => new RedirectException(...$arguments),
            default => null,
        };
    }

    /**
     * Statut HTTP de la réponse en échec ; `0` quand aucune réponse n'a été
     * obtenue. Également porté par `getCode()`.
     */
    public function status(): int
    {
        return $this->getCode();
    }

    /**
     * Code d'erreur structuré, quand lemlist en fournit un
     * (`{"error": {"code": "…", "message": "…"}}`).
     */
    public function errorCode(): ?string
    {
        $code = $this->details['code'] ?? null;

        return is_string($code) ? $code : null;
    }

    /**
     * Champs structurés du corps d'erreur, hors texte du message.
     *
     * @return array<string, mixed>
     */
    public function details(): array
    {
        return $this->details;
    }

    /**
     * En-têtes de réponse retenus pour le diagnostic.
     *
     * @return array<string, string>
     */
    public function responseHeaders(): array
    {
        return $this->responseHeaders;
    }

    /**
     * Corps brut de la réponse, tronqué.
     */
    public function responseBody(): string
    {
        return $this->responseBody;
    }

    /**
     * `mb_strcut` plutôt que `substr` : la coupe tombe sur une frontière de
     * caractère, si bien qu'un corps UTF-8 tronqué reste encodable en JSON.
     */
    protected static function truncate(string $value, int $maxLength): string
    {
        if (strlen($value) <= $maxLength) {
            return $value;
        }

        return mb_strcut($value, 0, $maxLength, 'UTF-8');
    }

    /**
     * lemlist répond tantôt en JSON, tantôt en texte brut (`Invalid API key`),
     * et un proxy en amont rend une page HTML : un corps qui n'est pas un objet
     * JSON n'est pas une erreur de décodage, c'est un message.
     *
     * @return array<array-key, mixed>
     */
    private static function decodeBody(#[\SensitiveParameter] Response $response): array
    {
        try {
            $decoded = json_decode($response->body(), true, flags: \JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            return [];
        }

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * @param array<array-key, mixed> $body
     */
    private static function extractError(array $body, #[\SensitiveParameter] Response $response): string
    {
        $error = $body['error'] ?? null;

        if (is_array($error) && is_string($error['message'] ?? null)) {
            return $error['message'];
        }

        foreach ([$error, $body['message'] ?? null] as $candidate) {
            if (is_string($candidate)) {
                return $candidate;
            }
        }

        return $response->body();
    }

    /**
     * Les champs d'une enveloppe `{"error": {"code": …}}` sont remontés au
     * même niveau que les autres détails.
     *
     * @param array<array-key, mixed> $body
     *
     * @return array<string, mixed>
     */
    private static function extractDetails(array $body): array
    {
        $error = $body['error'] ?? null;
        $source = array_diff_key($body, array_flip(self::TEXT_KEYS));

        if (is_array($error)) {
            $source += array_diff_key($error, array_flip(self::TEXT_KEYS));
        }

        $details = [];

        foreach ($source as $key => $value) {
            if (is_string($key)) {
                $details[$key] = $value;
            }
        }

        return $details;
    }

    /**
     * @return array<string, string>
     */
    private static function extractHeaders(#[\SensitiveParameter] Response $response): array
    {
        $received = [];

        foreach ($response->headers()->all() as $name => $value) {
            $received[strtolower((string) $name)] = self::stringifyHeader($value);
        }

        $headers = [];

        foreach (self::DIAGNOSTIC_HEADERS as $name) {
            $value = $received[strtolower($name)] ?? null;

            if (null !== $value) {
                $headers[$name] = self::truncate($value, self::MAX_MESSAGE_LENGTH);
            }
        }

        return $headers;
    }

    /**
     * PSR-7 autorise plusieurs valeurs pour un même en-tête ; tout ce qui
     * n'est pas représentable en texte est écarté.
     */
    private static function stringifyHeader(mixed $value): string
    {
        if (is_array($value)) {
            return implode(', ', array_map(self::stringifyHeader(...), $value));
        }

        return is_scalar($value) ? (string) $value : '';
    }
}
