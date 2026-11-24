<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Requests\Activities;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Delete Activity Recording & Transcript — `DELETE /activities/{activityId}/recording-transcript`.
 *
 * Fichier généré par `composer generate` : toute modification manuelle sera écrasée.
 *
 * @internal
 */
final class DeleteActivityRecordingTranscript extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(private readonly string $activityId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/activities/'.rawurlencode($this->activityId).'/recording-transcript';
    }
}
