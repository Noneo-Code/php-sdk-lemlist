<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Generator;

final readonly class DtoProperty
{
    /**
     * @param string      $type    type PHP natif, hors nullabilité
     * @param string|null $docType type de docblock quand le type natif ne suffit pas
     * @param string      $cast    expression de conversion, `%s` désignant la valeur brute
     */
    public function __construct(
        public string $name,
        public string $type,
        public ?string $docType,
        public string $cast,
    ) {
    }

    public static function scalar(string $name, string $type): self
    {
        return new self($name, $type, null, 'Cast::'.$type.'(%s)');
    }

    public static function dateTime(string $name): self
    {
        return new self($name, '\DateTimeImmutable', null, 'Cast::dateTime(%s)');
    }

    public static function object(string $name, string $dto): self
    {
        return new self($name, $dto, null, 'Cast::object(%s, '.$dto.'::fromArray(...))');
    }

    public static function objects(string $name, string $dto): self
    {
        return new self($name, 'array', 'list<'.$dto.'>', 'Cast::objects(%s, '.$dto.'::fromArray(...))');
    }

    public static function scalars(string $name, string $type): self
    {
        return new self($name, 'array', 'list<'.$type.'>', 'Cast::'.$type.'s(%s)');
    }

    public static function map(string $name): self
    {
        return new self($name, 'array', 'array<array-key, mixed>', 'Cast::map(%s)');
    }

    public static function mixed(string $name): self
    {
        return new self($name, 'mixed', null, '%s');
    }

    public function nativeType(): string
    {
        return 'mixed' === $this->type ? 'mixed' : '?'.$this->type;
    }
}
