<?php

use Illuminate\Database\Query\Builder;

Builder::macro(
    'whereRangeDoesNotExtendToTheLeftOf',
    function ($left, $right) {
        return $this->whereRaw('? &> ?', [$left, $right]);
    }
);

Builder::macro(
    'orWhereRangeDoesNotExtendToTheLeftOf',
    function ($left, $right) {
        return $this->whereRaw('? &> ?', [$left, $right], 'or');
    }
);
