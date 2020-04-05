<?php

namespace Belamov\PostrgesRange\Casts;

use Belamov\PostrgesRange\Ranges\IntegerRange;
use Illuminate\Database\Eloquent\Model;

class IntegerRangeCast extends RangeCast
{
    /**
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return IntegerRange|null
     */
    public function get($model, $key, $value, $attributes): ?IntegerRange
    {
        $matches = $this->parseStringRange($value);

        if (empty($matches)) {
            return null;
        }

        return new IntegerRange($matches[2], $matches[3], $matches[1], $matches[4]);
    }

}
