<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Testing;

use Noneo\Sdk\Lemlist\Lemlist;
use PHPUnit\Framework\Assert;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;
use Saloon\Repositories\Body\JsonBodyRepository;

/**
 * Double de test du SDK pour les consommateurs : réponses simulées associées
 * par méthode HTTP et chemin (wildcards `*` au sens de `fnmatch()`), ou
 * servies en file séquentielle quand la liste n'a pas de clés. Aucun symbole
 * Saloon n'entre ni ne sort.
 *
 * Les chemins sont relatifs à la base de l'API et s'écrivent comme dans la
 * documentation lemlist : `/campaigns/cam_123/leads/`.
 *
 * Le double ne bride pas le débit et ne rejoue rien : une erreur simulée
 * remonte immédiatement, sans attente.
 */
final class MockLemlist
{
    private const string BASE_PATH = '/api';

    /**
     * @var list<array{method: string, pattern: string, response: MockedResponse}>
     */
    private array $expectations = [];

    /**
     * @var list<MockedResponse>
     */
    private array $queue = [];

    private readonly bool $sequential;

    private readonly MockClient $mockClient;

    /**
     * @var list<RecordedRequest>
     */
    private array $recorded = [];

    /**
     * @var array<int, true>
     */
    private array $asserted = [];

    /**
     * @param array<int|string, MockedResponse> $responses
     */
    private function __construct(array $responses)
    {
        $this->sequential = array_is_list($responses);

        foreach ($responses as $key => $response) {
            if (is_int($key) !== $this->sequential) {
                throw new \LogicException('Impossible de mélanger réponses séquentielles et réponses par chemin.');
            }

            if (is_int($key)) {
                $this->queue[] = $response;

                continue;
            }

            [$method, $pattern] = $this->parseKey($key);
            $this->expectations[] = ['method' => $method, 'pattern' => $pattern, 'response' => $response];
        }

        $this->mockClient = new MockClient([
            '*' => fn (PendingRequest $pendingRequest): MockResponse => $this->respond($pendingRequest),
        ]);
    }

    /**
     * @param array<int|string, MockedResponse> $responses `'GET /team' => MockLemlist::json([...])`, ou une simple liste
     */
    public static function create(array $responses = []): self
    {
        return new self($responses);
    }

    /**
     * @param array<array-key, mixed> $body
     */
    public static function json(array $body, int $status = 200): MockedResponse
    {
        return new MockedResponse($status, $body);
    }

    /**
     * Corps brut — un export CSV, par exemple.
     */
    public static function text(string $body, int $status = 200): MockedResponse
    {
        return new MockedResponse($status, $body);
    }

    /**
     * @param array<array-key, mixed>|string $body lemlist répond tantôt en JSON, tantôt en texte brut
     */
    public static function error(int $status, array|string $body = []): MockedResponse
    {
        return new MockedResponse($status, $body);
    }

    public function lemlist(): Lemlist
    {
        $lemlist = new Lemlist('mock-key', maxRetries: 0);
        $lemlist->connector()->useRateLimitPlugin(false);
        $lemlist->connector()->withMockClient($this->mockClient);

        return $lemlist;
    }

    /**
     * Requêtes envoyées jusqu'ici, dans l'ordre.
     *
     * @return list<RecordedRequest>
     */
    public function requests(): array
    {
        return $this->recorded;
    }

    public function assertSent(string $method, string $path): void
    {
        $found = false;

        foreach ($this->recorded as $index => $request) {
            if ($this->matches($method, $path, $request)) {
                $this->asserted[$index] = true;
                $found = true;
            }
        }

        Assert::assertTrue($found, sprintf(
            "Aucune requête %s %s envoyée. Requêtes vues :\n%s",
            strtoupper($method),
            $path,
            $this->summary($this->recorded),
        ));
    }

    public function assertNotSent(string $method, string $path): void
    {
        $matched = array_values(array_filter(
            $this->recorded,
            fn (RecordedRequest $request): bool => $this->matches($method, $path, $request),
        ));

        Assert::assertSame([], $matched, sprintf('Une requête %s %s a été envoyée.', strtoupper($method), $path));
    }

    public function assertNothingSent(): void
    {
        Assert::assertSame([], $this->recorded, sprintf(
            "Des requêtes ont été envoyées :\n%s",
            $this->summary($this->recorded),
        ));
    }

    /**
     * Chaque requête enregistrée doit avoir été couverte par un `assertSent()`
     * antérieur : le filet qui révèle les appels que le test ne décrit pas.
     */
    public function assertNothingElseSent(): void
    {
        $unasserted = array_values(array_diff_key($this->recorded, $this->asserted));

        Assert::assertSame([], $unasserted, sprintf(
            "Des requêtes n'ont fait l'objet d'aucun assertSent() :\n%s",
            $this->summary($unasserted),
        ));
    }

    private function respond(PendingRequest $pendingRequest): MockResponse
    {
        $body = $pendingRequest->body();
        $json = $body instanceof JsonBodyRepository ? $body->all() : null;

        $request = new RecordedRequest(
            $pendingRequest->getMethod()->value,
            $this->relativePath($pendingRequest->getUrl()),
            $pendingRequest->query()->all(),
            is_array($json) ? $json : null,
        );
        $this->recorded[] = $request;

        if ($this->sequential) {
            $next = array_shift($this->queue);

            if (!$next instanceof MockedResponse) {
                throw new UnexpectedRequestException($request->method, $request->path);
            }

            return MockResponse::make($next->body, $next->status);
        }

        foreach ($this->expectations as $expectation) {
            if ($this->matches($expectation['method'], $expectation['pattern'], $request)) {
                return MockResponse::make($expectation['response']->body, $expectation['response']->status);
            }
        }

        throw new UnexpectedRequestException($request->method, $request->path);
    }

    private function matches(string $method, string $pattern, RecordedRequest $request): bool
    {
        return strtoupper($method) === $request->method && fnmatch($pattern, $request->path);
    }

    private function relativePath(string $url): string
    {
        $path = (string) parse_url($url, \PHP_URL_PATH);

        if (!str_starts_with($path, self::BASE_PATH.'/')) {
            return $path;
        }

        return substr($path, strlen(self::BASE_PATH));
    }

    /**
     * @return array{0: string, 1: string}
     */
    private function parseKey(string $key): array
    {
        $parts = preg_split('/\s+/', trim($key), 2);

        if (!is_array($parts) || 2 !== count($parts) || !str_starts_with($parts[1], '/')) {
            throw new \LogicException(sprintf('Clé de réponse invalide : « %s » (attendu : « METHODE /chemin », ex. « GET /team »).', $key));
        }

        return [strtoupper($parts[0]), $parts[1]];
    }

    /**
     * @param list<RecordedRequest> $requests
     */
    private function summary(array $requests): string
    {
        if ([] === $requests) {
            return '(aucune)';
        }

        return implode("\n", array_map(
            static fn (RecordedRequest $request): string => sprintf('- %s %s', $request->method, $request->path),
            $requests,
        ));
    }
}
