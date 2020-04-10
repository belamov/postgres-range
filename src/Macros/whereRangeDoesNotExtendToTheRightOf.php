<?php

use Illuminate\Database\Query\Builder;

Builder::macro(
    'whereRangeDoesNotExtendToTheRightOf',
    function ($left, $right) {
        return $this->whereRaw('? &< ?', [$left, $right]);
    }
);

Builder::macro(
    'orWhereRangeDoesNotExtendToTheRightOf',
    function ($left, $right) {
        return $this->whereRaw('? &< ?', [$left, $right], 'or');
    }
);
