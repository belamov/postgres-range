<?php

use Illuminate\Database\Query\Builder;

Builder::macro(
    'whereRangeOverlaps',
    function ($left, $right) {
        return $this->whereRaw('? && ?', [$left, $right]);
    }
);

Builder::macro(
    'orWhereRangeOverlaps',
    function ($left, $right) {
        return $this->whereRaw('? && ?', [$left, $right], 'or');
    }
);
