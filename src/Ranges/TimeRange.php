<?php

namespace Belamov\PostgresRange\Ranges;

use Carbon\CarbonImmutable;

/**
 * Class TimeRange
 *
 * @method string|null from()
 * @method string|null to()
 *
 * @package Belamov\PostgresRange\Ranges
 */
class TimeRange extends Range
{
    use StringifiesBoundariesFromDateTimeInterface;

    /**
     * @param  string  $boundary
     * @return string
     */
    protected function transformBoundary(string $boundary): string
    {
        return CarbonImmutable::parse($boundary)->toTimeString();
    }

    /**
     * @inheritDoc
     */
    protected function getBoundaryFormat(): string
    {
        return 'H:i:s';
    }
}
