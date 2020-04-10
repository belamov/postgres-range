<?php

use Illuminate\Database\Query\Builder;

Builder::macro(
    'whereRangeStrictlyLeftOf',
    function ($left, $right) {
        return $this->whereRaw('? << ?', [$left, $right]);
    }
);

Builder::macro(
    'orWhereRangeStrictlyLeftOf',
    function ($left, $right) {
        return $this->whereRaw('? << ?', [$left, $right], 'or');
    }
);
