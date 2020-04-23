<?php

namespace Belamov\PostgresRange\Ranges;

use Carbon\CarbonImmutable;

/**
 * Class TimeRange.
 *
 * @method string|null from()
 * @method string|null to()
 */
class TimeRange extends Range
{
    use StringifiesBoundariesFromDateTimeInterface;

    public function forSql(): string
    {
        $timerangeTypeName = config('postgres-range.timerange_typename');
        return "'$this'::$timerangeTypeName";
    }

    /**
     * @param  string  $boundary
     * @return string
     */
    protected function transformBoundary(string $boundary): string
    {
        return CarbonImmutable::parse($boundary)->toTimeString();
    }

    /**
     * {@inheritdoc}
     */
    protected function getBoundaryFormat(): string
    {
        return 'H:i:s';
    }
}
