<?php

namespace Belamov\PostrgesRange\Casts;

use Belamov\PostrgesRange\Ranges\Range;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

abstract class RangeCast implements CastsAttributes
{
    /**
     * @param Model $model
     * @param string $key
     * @param Range $value
     * @param array $attributes
     * @return array
     */
    public function set($model, $key, $value, $attributes): array
    {
        return [
            $key => $this->serializeRange($value)
        ];
    }

    /**
     * @param Range $range
     * @return string|null
     */
    protected function serializeRange(?Range $range): ?string
    {
        return (string) $range;
    }

    /**
     * @param $value
     * @return array
     */
    protected function parseStringRange($value): array
    {
        $matches = [];
        preg_match('/([\[(])(.*),(.*)([])])/', $value, $matches);
        return $matches;
    }
}
