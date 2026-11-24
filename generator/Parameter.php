<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Generator;

final readonly class Parameter
{
    public const string PATH = 'path';
    public const string QUERY = 'query';
    public const string BODY = 'body';
    public const string FILE = 'file';
    public const string ITEMS = 'items';
    public const string ADDITIONAL = 'additional';

    /**
     * @param string      $type    type PHP natif, hors nullabilité
     * @param string|null $docType type de docblock quand le type natif ne suffit pas (`list<string>`)
     */
    public function __construct(
        public string $name,
        public string $in,
        public string $type,
        public ?string $docType,
        public bool $required,
        public string $description = '',
    ) {
    }

    public function isNullable(): bool
    {
        return !$this->required && self::ADDITIONAL !== $this->in && 'mixed' !== $this->type;
    }

    public function nativeType(): string
    {
        if (!$this->isNullable()) {
            return $this->type;
        }

        return str_contains($this->type, '|') ? $this->type.'|null' : '?'.$this->type;
    }

    public function documentedType(): string
    {
        $type = $this->docType ?? $this->type;

        return $this->isNullable() ? $type.'|null' : $type;
    }

    public function defaultValue(): string
    {
        return match (true) {
            $this->required => '',
            self::ADDITIONAL === $this->in => ' = []',
            default => ' = null',
        };
    }

    /**
     * Déclaration du paramètre, `$modifiers` valant `private readonly ` pour
     * une propriété promue et `$variable` remplaçant, au besoin, son nom.
     */
    public function declaration(string $modifiers = '', ?string $variable = null): string
    {
        return sprintf(
            '%s%s%s $%s%s',
            Naming::isSensitive($this->name) ? '#[\SensitiveParameter] ' : '',
            $modifiers,
            $this->nativeType(),
            $variable ?? $this->name,
            $this->defaultValue(),
        );
    }
}
