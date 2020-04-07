<?php

namespace Belamov\PostgresRange\Ranges;

/**
 * Class IntegerRange
 *
 * @method int|null from()
 * @method int|null to()
 *
 * @package Belamov\PostgresRange\Ranges
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
