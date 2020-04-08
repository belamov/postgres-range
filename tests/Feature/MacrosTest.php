<?php

namespace Belamov\PostgresRange\Tests\Unit;

use Belamov\PostgresRange\Models\Range;
use Belamov\PostgresRange\Ranges\IntegerRange;
use Belamov\PostgresRange\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MacrosTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function where_range_contains_macro_test(): void
    {
        $range = new IntegerRange(10, 11);

        $sqlWithMacro = Range::whereRangeContains('integer_range', $range)
            ->whereRangeContains('integer_range', $range);
        $rawSql = Range::whereRaw('integer_range @> ?', [$range])
            ->whereRaw('integer_range @> ?', [$range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function or_where_range_contains_macro_test(): void
    {
        $range = new IntegerRange(10, 11);

        $sqlWithMacro = Range::orWhereRangeContains('integer_range', $range)
            ->orWhereRangeContains('integer_range', $range);
        $rawSql = Range::orWhereRaw('integer_range @> ?', [$range])
            ->orWhereRaw('integer_range @> ?', [$range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function where_range_is_contained_by_macro_test(): void
    {
        $range = new IntegerRange(10, 11);

        $sqlWithMacro = Range::whereRangeIsContainedBy('integer_range', $range)
            ->whereRangeIsContainedBy('integer_range', $range);
        $rawSql = Range::whereRaw('integer_range <@ ?', [$range])
            ->whereRaw('integer_range <@ ?', [$range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function or_where_range_is_contained_by_macro_test(): void
    {
        $range = new IntegerRange(10, 11);

        $sqlWithMacro = Range::orWhereRangeIsContainedBy('integer_range', $range)
            ->orWhereRangeIsContainedBy('integer_range', $range);
        $rawSql = Range::orWhereRaw('integer_range <@ ?', [$range])
            ->orWhereRaw('integer_range <@ ?', [$range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function where_range_is_overlaps_by_macro_test(): void
    {
        $range = new IntegerRange(10, 11);

        $sqlWithMacro = Range::whereRangeOverlaps('integer_range', $range)
            ->whereRangeOverlaps('integer_range', $range);
        $rawSql = Range::whereRaw('integer_range && ?', [$range])
            ->whereRaw('integer_range && ?', [$range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function or_where_range_overlaps_by_macro_test(): void
    {
        $range = new IntegerRange(10, 11);

        $sqlWithMacro = Range::orWhereRangeOverlaps('integer_range', $range)
            ->orWhereRangeOverlaps('integer_range', $range);
        $rawSql = Range::orWhereRaw('integer_range && ?', [$range])
            ->orWhereRaw('integer_range && ?', [$range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function where_range_is_strictly_left_of_by_macro_test(): void
    {
        $range = new IntegerRange(10, 11);

        $sqlWithMacro = Range::whereRangeStrictlyLeftOf('integer_range', $range)
            ->whereRangeStrictlyLeftOf('integer_range', $range);
        $rawSql = Range::whereRaw('integer_range << ?', [$range])
            ->whereRaw('integer_range << ?', [$range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function or_where_range_strictly_left_of_by_macro_test(): void
    {
        $range = new IntegerRange(10, 11);

        $sqlWithMacro = Range::orWhereRangeStrictlyLeftOf('integer_range', $range)
            ->orWhereRangeStrictlyLeftOf('integer_range', $range);
        $rawSql = Range::orWhereRaw('integer_range << ?', [$range])
            ->orWhereRaw('integer_range << ?', [$range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function where_range_is_strictly_right_of_by_macro_test(): void
    {
        $range = new IntegerRange(10, 11);

        $sqlWithMacro = Range::whereRangeStrictlyRightOf('integer_range', $range)
            ->whereRangeStrictlyRightOf('integer_range', $range);
        $rawSql = Range::whereRaw('integer_range >> ?', [$range])
            ->whereRaw('integer_range >> ?', [$range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function or_where_range_strictly_right_of_by_macro_test(): void
    {
        $range = new IntegerRange(10, 11);

        $sqlWithMacro = Range::orWhereRangeStrictlyRightOf('integer_range', $range)
            ->orWhereRangeStrictlyRightOf('integer_range', $range);
        $rawSql = Range::orWhereRaw('integer_range >> ?', [$range])
            ->orWhereRaw('integer_range >> ?', [$range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function where_range_does_not_extend_to_the_right_of_macro_test(): void
    {
        $range = new IntegerRange(10, 11);

        $sqlWithMacro = Range::whereRangeDoesNotExtendToTheRightOf('integer_range', $range)
            ->whereRangeDoesNotExtendToTheRightOf('integer_range', $range);
        $rawSql = Range::whereRaw('integer_range &< ?', [$range])
            ->whereRaw('integer_range &< ?', [$range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function or_where_does_not_extend_to_the_right_of_macro_test(): void
    {
        $range = new IntegerRange(10, 11);

        $sqlWithMacro = Range::orWhereRangeDoesNotExtendToTheRightOf('integer_range', $range)
            ->orWhereRangeDoesNotExtendToTheRightOf('integer_range', $range);
        $rawSql = Range::orWhereRaw('integer_range &< ?', [$range])
            ->orWhereRaw('integer_range &< ?', [$range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function where_range_does_not_extend_to_the_left_of_macro_test(): void
    {
        $range = new IntegerRange(10, 11);

        $sqlWithMacro = Range::whereRangeDoesNotExtendToTheLeftOf('integer_range', $range)
            ->whereRangeDoesNotExtendToTheLeftOf('integer_range', $range);
        $rawSql = Range::whereRaw('integer_range &> ?', [$range])
            ->whereRaw('integer_range &> ?', [$range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function or_where_range_does_not_extend_to_the_left_of_macro_test(): void
    {
        $range = new IntegerRange(10, 11);

        $sqlWithMacro = Range::orWhereRangeDoesNotExtendToTheLeftOf('integer_range', $range)
            ->orWhereRangeDoesNotExtendToTheLeftOf('integer_range', $range);
        $rawSql = Range::orWhereRaw('integer_range &> ?', [$range])
            ->orWhereRaw('integer_range &> ?', [$range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function where_range_adjacent_to_macro_test(): void
    {
        $range = new IntegerRange(10, 11);

        $sqlWithMacro = Range::whereRangeAdjacentTo('integer_range', $range)
            ->whereRangeAdjacentTo('integer_range', $range);
        $rawSql = Range::whereRaw('integer_range -|- ?', [$range])
            ->whereRaw('integer_range -|- ?', [$range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function or_where_range_adjacent_to_macro_test(): void
    {
        $range = new IntegerRange(10, 11);

        $sqlWithMacro = Range::orWhereRangeAdjacentTo('integer_range', $range)
            ->orWhereRangeAdjacentTo('integer_range', $range);
        $rawSql = Range::orWhereRaw('integer_range -|- ?', [$range])
            ->orWhereRaw('integer_range -|- ?', [$range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }
}
