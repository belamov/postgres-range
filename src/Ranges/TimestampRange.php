<?php

namespace Belamov\PostgresRange\Ranges;

use Carbon\CarbonImmutable;

/**
 * Class TimestampRange.
 *
 * @method CarbonImmutable|null from()
 * @method CarbonImmutable|null to()
 */
class TimestampRange extends Range
{
    use StringifiesBoundariesFromDateTimeInterface;

    /**
     * @param  string  $boundary
     * @return CarbonImmutable
     */
    protected function transformBoundary(string $boundary): CarbonImmutable
    {
        return CarbonImmutable::parse(str_replace('"', '', $boundary));
    }

    /**
     * {@inheritdoc}
     */
    protected function getBoundaryFormat(): string
    {
        return 'Y-m-d H:i:s';
    }
}
