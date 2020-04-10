<?php

use Illuminate\Database\Query\Builder;

Builder::macro(
    'whereRangeContains',
    function ($left, $right) {
        return $this->whereRaw('? @> ?', [$left, $right]);
    }
);

Builder::macro(
    'orWhereRangeContains',
    function ($left, $right) {
        return $this->whereRaw('? @> ?', [$left, $right], 'or');
    }
);
