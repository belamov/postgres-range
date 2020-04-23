<?php

namespace Belamov\PostgresRange\Macros;

use Belamov\PostgresRange\Ranges\Range;
use Illuminate\Database\Query\Builder;

class QueryBuilderMacros
{
    public array $macrosParams = [
        ['RangeContains', '@>'],
        ['RangeDoesNotExtendToTheLeftOf', '&>'],
        ['RangeDoesNotExtendToTheRightOf', '&<'],
        ['RangeAdjacentTo', '-|-'],
        ['RangeIsContainedBy', '<@'],
        ['RangeRangeOverlaps', '&&'],
        ['RangeStrictlyLeftOf', '<<'],
        ['RangeStrictlyRightOf', '>>'],

    ];

    public function register(): void
    {
        foreach ($this->macrosParams as [$operatorName, $operator]) {
            Builder::macro(
                "where{$operatorName}",
                fn($left, $right) => $this->whereRaw(
                    sprintf('%s %s %s',
                        $left instanceof Range ? $left->forSql() : $left,
                        $operator,
                        $right instanceof Range ? $right->forSql() : $right
                    )
                )
            );

            Builder::macro(
                "orWhere{$operatorName}",
                fn($left, $right) => $this->orWhereRaw(
                    sprintf('%s %s %s',
                        $left instanceof Range ? $left->forSql() : $left,
                        $operator,
                        $right instanceof Range ? $right->forSql() : $right
                    )
                )
            );
        }
    }
}