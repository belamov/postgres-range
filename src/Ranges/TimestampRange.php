<?php

namespace Belamov\PostrgesRange\Ranges;

use Carbon\CarbonImmutable;

/**
 * Class TimestampRange
 *
 * @method CarbonImmutable|null from()
 * @method CarbonImmutable|null to()
 *
 * @package Belamov\PostrgesRange\Ranges
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
     * @inheritDoc
     */
    protected function getBoundaryFormat(): string
    {
        return 'Y-m-d H:i:s';
    }
}
