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
    /**
     * @param  string  $boundary
     * @return CarbonImmutable
     */
    protected function transformBoundary(string $boundary): CarbonImmutable
    {
        return CarbonImmutable::parse(str_replace('"', '', $boundary));
    }
}
