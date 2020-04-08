<?php

use Illuminate\Database\Query\Builder;

Builder::macro(
    'whereRangeStrictlyLeftOf',
    function ($column, $value) {
        return $this->whereRaw("{$column} << ?", [$value]);
    }
);

Builder::macro(
    'orWhereRangeStrictlyLeftOf',
    function ($column, $value) {
        return $this->whereRaw("{$column} << ?", [$value], 'or');
    }
);
