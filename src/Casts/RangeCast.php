<?php

namespace Belamov\PostgresRange\Casts;

use Belamov\PostgresRange\Ranges\Range;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

abstract class RangeCast implements CastsAttributes
{
    /**
     * @param  Model  $model
     * @param  string  $key
     * @param  Range  $value
     * @param  array  $attributes
     * @return array
     */
    public function set($model, $key, $value, $attributes): array
    {
        return [
            $key => $this->serializeRange($value),
        ];
    }

    /**
     * @param  Range|null  $range
     * @return string|null
     */
    protected function serializeRange(?Range $range): ?string
    {
        if ($range === null) {
            return null;
        }

        return (string) $range;
    }

    /**
     * @param  Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return Range|null
     */
    public function get($model, $key, $value, $attributes): ?Range
    {
        $matches = $this->parseStringRange($value);

        if (empty($matches)) {
            return null;
        }

        return $this->getRangeInstance($matches);
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

    /**
     * @param  array  $params
     * @return Range
     */
    abstract protected function getRangeInstance(array $params): Range;
}
