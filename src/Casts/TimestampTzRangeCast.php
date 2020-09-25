<?php

namespace Belamov\PostgresRange\Casts;

use Belamov\PostgresRange\Ranges\TimestampTzRange;

class TimestampTzRangeCast extends RangeCast
{
    /**
     * @param  array  $matches
     * @return TimestampTzRange
     */
    public function getRangeInstance(array $matches): TimestampTzRange
    {
        return new TimestampTzRange($matches[2], $matches[3], $matches[1], $matches[4]);
    }
}
