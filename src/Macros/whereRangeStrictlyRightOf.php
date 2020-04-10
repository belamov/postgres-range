<?php

use Illuminate\Database\Query\Builder;

Builder::macro(
    'whereRangeStrictlyRightOf',
    function ($left, $right) {
        return $this->whereRaw('? >> ?', [$left, $right]);
    }
);

Builder::macro(
    'orWhereRangeStrictlyRightOf',
    function ($left, $right) {
        return $this->whereRaw('? >> ?', [$left, $right], 'or');
    }
);
