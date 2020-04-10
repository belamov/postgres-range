<?php

namespace Belamov\PostgresRange\Ranges;

/**
 * Class IntegerRange.
 *
 * @method int|null from()
 * @method int|null to()
 */
class IntegerRange extends CanonicalRange
{
    /**
     * @param  string  $boundary
     * @return string
     */
    protected function addToDiscreteBoundary(string $boundary): string
    {
        return (string) ($this->transformBoundary($boundary) + 1);
    }

    /**
     * @param  string  $boundary
     * @return int
     */
    protected function transformBoundary(string $boundary): int
    {
        return (int) $boundary;
    }
}
