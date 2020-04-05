<?php


namespace Belamov\PostrgesRange\Casts;

use Belamov\PostrgesRange\Ranges\TimeRange;
use Illuminate\Database\Eloquent\Model;

class TimeRangeCast extends RangeCast
{
    /**
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return TimeRange|null
     */
    public function get($model, $key, $value, $attributes): ?TimeRange
    {
        $matches = $this->parseStringRange($value);

        if(empty($matches)){
            return null;
        }

        return new TimeRange($matches[2], $matches[3], $matches[1], $matches[4]);
    }

}
