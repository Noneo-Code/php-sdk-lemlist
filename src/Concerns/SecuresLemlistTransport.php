<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Concerns;

use GuzzleHttp\RequestOptions;
use Noneo\Sdk\Lemlist\Lemlist;

/**
 * Invariants de transport du SDK :
 *
 * - **Pas de redirection suivie.** Une API JSON ne redirige pas ; suivre un 301
 *   rejouerait l'en-tête `Authorization` vers l'hôte annoncé par la réponse.
 * - **User-Agent identifiant.** Utile au support lemlist pour repérer nos
 *   appels dans leurs journaux.
 */
trait SecuresLemlistTransport
{
    /**
     * @return array<string, mixed>
     */
    protected function defaultConfig(): array
    {
        return [RequestOptions::ALLOW_REDIRECTS => false];
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultHeaders(): array
    {
        return ['User-Agent' => 'noneo-sdk-lemlist/'.Lemlist::VERSION];
    }
}
