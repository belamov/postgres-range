<?php

use Illuminate\Database\Query\Builder;

Builder::macro(
    'whereRangeStrictlyRightOf',
    function ($column, $value) {
        return $this->whereRaw('? >> ?', [$column, $value]);
    }
);

Builder::macro(
    'orWhereRangeStrictlyRightOf',
    function ($column, $value) {
        return $this->whereRaw('? >> ?', [$column, $value], 'or');
    }
);
