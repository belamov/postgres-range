<?php


namespace Belamov\PostrgesRange\Casts;

use Belamov\PostrgesRange\Ranges\DateRange;
use Illuminate\Database\Eloquent\Model;

class DateRangeCast extends RangeCast
{
    /**
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return DateRange|null
     */
    public function get($model, $key, $value, $attributes): ?DateRange
    {
        $matches = $this->parseStringRange($value);

        if (empty($matches)) {
            return null;
        }

        return new DateRange($matches[2], $matches[3], $matches[1], $matches[4]);
    }

}
