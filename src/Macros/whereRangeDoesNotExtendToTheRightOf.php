<?php

use Illuminate\Database\Query\Builder;

Builder::macro(
    'whereRangeDoesNotExtendToTheRightOf',
    function ($column, $value) {
        return $this->whereRaw("{$column} &< ?", [$value]);
    }
);

Builder::macro(
    'orWhereRangeDoesNotExtendToTheRightOf',
    function ($column, $value) {
        return $this->whereRaw("{$column} &< ?", [$value], 'or');
    }
);
