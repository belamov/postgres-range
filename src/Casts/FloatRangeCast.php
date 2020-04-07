<?php

namespace Belamov\PostgresRange\Casts;

use Belamov\PostgresRange\Ranges\FloatRange;

class FloatRangeCast extends RangeCast
{
    /**
     * @param $matches
     * @return FloatRange
     */
    public function getRangeInstance(array $matches): FloatRange
    {
        return new FloatRange($matches[2], $matches[3], $matches[1], $matches[4]);
    }

}
