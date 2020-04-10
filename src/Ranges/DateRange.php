<?php

namespace Belamov\PostgresRange\Ranges;

use Carbon\CarbonImmutable;

/**
 * Class DateRange.
 *
 * @method CarbonImmutable|null from()
 * @method CarbonImmutable|null to()
 */
class DateRange extends CanonicalRange
{
    use StringifiesBoundariesFromDateTimeInterface;

    /**
     * @param  string  $boundary
     * @return string
     */
    protected function addToDiscreteBoundary(string $boundary): string
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
     * {@inheritdoc}
     */
    protected function getBoundaryFormat(): string
    {
        return 'Y-m-d';
    }
}
