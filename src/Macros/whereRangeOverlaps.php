<?php

use Illuminate\Database\Query\Builder;

Builder::macro(
    'whereRangeOverlaps',
    function ($column, $value) {
        return $this->whereRaw("{$column} && ?", [$value]);
    }
);

Builder::macro(
    'orWhereRangeOverlaps',
    function ($column, $value) {
        return $this->whereRaw("{$column} && ?", [$value], 'or');
    }
);