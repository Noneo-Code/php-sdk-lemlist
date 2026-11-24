<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Generator;

/**
 * Ce que rend une méthode de ressource.
 */
final readonly class Returns
{
    /** Un DTO : la spec nomme un schéma objet. */
    public const string DTO = 'dto';
    /** Une liste de DTO : tableau d'un schéma nommé. */
    public const string DTOS = 'dtos';
    /** Un tableau décodé : la spec décrit la réponse de façon anonyme. */
    public const string DECODED = 'decoded';
    /** La valeur reçue telle quelle : la spec ne décrit rien, ou plusieurs formats. */
    public const string VALUE = 'value';
    /** Le corps brut : export CSV. */
    public const string TEXT = 'text';

    public function __construct(
        public string $kind,
        public ?string $dto = null,
    ) {
    }
}
