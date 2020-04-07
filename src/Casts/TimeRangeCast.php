<?php

namespace Belamov\PostgresRange\Casts;

use Belamov\PostgresRange\Ranges\TimeRange;

class TimeRangeCast extends RangeCast
{
    /**
     * @param  array  $matches
     * @return TimeRange
     */
    public function getRangeInstance(array $matches): TimeRange
    {
        return new TimeRange($matches[2], $matches[3], $matches[1], $matches[4]);
    }

}
