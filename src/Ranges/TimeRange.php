<?php

namespace Belamov\PostrgesRange\Ranges;

/**
 * Class TimeRange
 *
 * @method string|null from()
 * @method string|null to()
 *
 * @package Belamov\PostrgesRange\Ranges
 */
class TimeRange extends Range
{
    /**
     * @param  string  $boundary
     * @return string
     */
    protected function transformBoundary(string $boundary): string
    {
        return $boundary;
    }
}
