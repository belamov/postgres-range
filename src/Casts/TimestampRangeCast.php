<?php


namespace Belamov\PostrgesRange\Casts;

use Belamov\PostrgesRange\Ranges\TimestampRange;
use Illuminate\Database\Eloquent\Model;

class TimestampRangeCast extends RangeCast
{
    /**
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return TimestampRange|null
     */
    public function get($model, $key, $value, $attributes): ?TimestampRange
    {
        $matches = $this->parseStringRange($value);

        if (empty($matches)) {
            return null;
        }

        return new TimestampRange($matches[2], $matches[3], $matches[1], $matches[4]);
    }

}
