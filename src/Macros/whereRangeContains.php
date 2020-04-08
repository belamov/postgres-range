<?php

use Illuminate\Database\Query\Builder;

Builder::macro(
    'whereRangeContains',
    function ($column, $value) {
        return $this->whereRaw("{$column} @> ?", [$value]);
    }
);

Builder::macro(
    'orWhereRangeContains',
    function ($column, $value) {
        return $this->whereRaw("{$column} @> ?", [$value], 'or');
    }
);
