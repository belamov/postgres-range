<?php

namespace Belamov\PostrgesRange\Casts;

use Belamov\PostrgesRange\Ranges\DateRange;

class DateRangeCast extends RangeCast
{
    /**
     * @param $matches
     * @return DateRange
     */
    public function getRangeInstance(array $matches): DateRange
    {
        return new DateRange($matches[2], $matches[3], $matches[1], $matches[4]);
    }

}
