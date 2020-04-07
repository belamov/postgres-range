<?php

use Illuminate\Database\Query\Builder;

Builder::macro(
    'whereRangeAdjacentTo',
    function ($column, $value) {
        return $this->whereRaw("{$column} -|- ?", [$value]);
    }
);

Builder::macro(
    'orWhereRangeAdjacentTo',
    function ($column, $value) {
        return $this->whereRaw("{$column} -|- ?", [$value], 'or');
    }
);