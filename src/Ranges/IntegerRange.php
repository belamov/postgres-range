<?php

namespace Belamov\PostrgesRange\Ranges;

/**
 * Class IntegerRange
 *
 * @method int|null from()
 * @method int|null to()
 *
 * @package Belamov\PostrgesRange\Ranges
 */
class IntegerRange extends CanonicalRange
{
    /**
     * @param $boundary
     * @return string
     */
    protected function addToDiscreteBoundary($boundary): string
    {
        return (string)($this->transformBoundary($boundary) + 1);
    }

    /**
     * @param  string  $boundary
     * @return int
     */
    protected function transformBoundary(string $boundary): int
    {
        return (int)$boundary;
    }
}
