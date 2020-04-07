<?php

namespace Belamov\PostgresRange\Ranges;

use Carbon\CarbonImmutable;

/**
 * Class DateRange
 *
 * @method CarbonImmutable|null from()
 * @method CarbonImmutable|null to()
 *
 * @package Belamov\PostgresRange\Ranges
 */
class DateRange extends CanonicalRange
{
    use StringifiesBoundariesFromDateTimeInterface;

    /**
     * @param $boundary
     * @return string
     */
    protected function addToDiscreteBoundary($boundary): string
    {
        return $this->transformBoundary($boundary)->addDay()->toDateString();
    }

    /**
     * @param  string  $boundary
     * @return CarbonImmutable
     */
    protected function transformBoundary(string $boundary): CarbonImmutable
    {
        return CarbonImmutable::parse($boundary);
    }

    /**
     * @inheritDoc
     */
    protected function getBoundaryFormat(): string
    {
        return 'Y-m-d';
    }
}
