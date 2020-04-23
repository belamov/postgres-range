<?php

namespace Belamov\PostgresRange\Ranges;

/**
 * Class FloatRange.
 *
 * @method float|null from()
 * @method float|null to()
 */
class FloatRange extends Range
{
    /**
     * @param  string  $boundary
     * @return float
     */
    protected function transformBoundary(string $boundary): float
    {
        return (float) $boundary;
    }

    public function forSql(): string
    {
        return "'$this'::numrange";
    }
}
