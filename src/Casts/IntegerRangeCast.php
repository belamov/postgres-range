<?php

namespace Belamov\PostgresRange\Casts;

use Belamov\PostgresRange\Ranges\IntegerRange;

class IntegerRangeCast extends RangeCast
{
    /**
     * @param  array  $matches
     * @return IntegerRange
     */
    public function getRangeInstance(array $matches): IntegerRange
    {
        return new IntegerRange($matches[2], $matches[3], $matches[1], $matches[4]);
    }
}
