<?php

namespace Belamov\PostrgesRange\Ranges;

/**
 * Class FloatRange
 *
 * @method float|null from()
 * @method float|null to()
 *
 * @package Belamov\PostrgesRange\Ranges
 */
class FloatRange extends Range
{
    /**
     * @param  string  $boundary
     * @return float
     */
    protected function transformBoundary(string $boundary): float
    {
        return (float)$boundary;
    }
}
