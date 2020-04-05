<?php

namespace Belamov\PostrgesRange\Casts;

use Belamov\PostrgesRange\Ranges\FloatRange;
use Illuminate\Database\Eloquent\Model;

class FloatRangeCast extends RangeCast
{
    /**
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return FloatRange|null
     */
    public function get($model, $key, $value, $attributes): ?FloatRange
    {
        $matches = $this->parseStringRange($value);

        if (empty($matches)) {
            return null;
        }

        return new FloatRange($matches[2], $matches[3], $matches[1], $matches[4]);
    }

}
