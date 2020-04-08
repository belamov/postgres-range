<?php

namespace Belamov\PostgresRange\Tests\Unit;

use Belamov\PostgresRange\Models\Range;
use Belamov\PostgresRange\Ranges\IntegerRange;
use Belamov\PostgresRange\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MacrosTest extends TestCase
{
    use RefreshDatabase;
    private IntegerRange $range;
    private string $columnName = 'integer_range';

    /** @test */
    public function where_range_contains_macro_test(): void
    {
        $sqlWithMacro = Range::whereRangeContains($this->columnName, $this->range)
            ->whereRangeContains($this->columnName, $this->range);

        $rawSql = Range::whereRaw('? @> ?', [$this->columnName, $this->range])
            ->whereRaw('? @> ?', [$this->columnName, $this->range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function or_where_range_contains_macro_test(): void
    {
        $sqlWithMacro = Range::orWhereRangeContains($this->columnName, $this->range)
            ->orWhereRangeContains($this->columnName, $this->range);

        $rawSql = Range::orWhereRaw('? @> ?', [$this->columnName, $this->range])
            ->orWhereRaw('? @> ?', [$this->columnName, $this->range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function where_range_is_contained_by_macro_test(): void
    {
        $sqlWithMacro = Range::whereRangeIsContainedBy($this->columnName, $this->range)
            ->whereRangeIsContainedBy($this->columnName, $this->range);

        $rawSql = Range::whereRaw('? <@ ?', [$this->columnName, $this->range])
            ->whereRaw('? <@ ?', [$this->columnName, $this->range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function or_where_range_is_contained_by_macro_test(): void
    {
        $sqlWithMacro = Range::orWhereRangeIsContainedBy($this->columnName, $this->range)
            ->orWhereRangeIsContainedBy($this->columnName, $this->range);

        $rawSql = Range::orWhereRaw('? <@ ?', [$this->columnName, $this->range])
            ->orWhereRaw('? <@ ?', [$this->columnName, $this->range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function where_range_is_overlaps_by_macro_test(): void
    {
        $sqlWithMacro = Range::whereRangeOverlaps($this->columnName, $this->range)
            ->whereRangeOverlaps($this->columnName, $this->range);

        $rawSql = Range::whereRaw('? && ?', [$this->columnName, $this->range])
            ->whereRaw('? && ?', [$this->columnName, $this->range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function or_where_range_overlaps_by_macro_test(): void
    {
        $sqlWithMacro = Range::orWhereRangeOverlaps($this->columnName, $this->range)
            ->orWhereRangeOverlaps($this->columnName, $this->range);

        $rawSql = Range::orWhereRaw('? && ?', [$this->columnName, $this->range])
            ->orWhereRaw('? && ?', [$this->columnName, $this->range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function where_range_is_strictly_left_of_by_macro_test(): void
    {
        $sqlWithMacro = Range::whereRangeStrictlyLeftOf($this->columnName, $this->range)
            ->whereRangeStrictlyLeftOf($this->columnName, $this->range);

        $rawSql = Range::whereRaw('? << ?', [$this->columnName, $this->range])
            ->whereRaw('? << ?', [$this->columnName, $this->range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function or_where_range_strictly_left_of_by_macro_test(): void
    {
        $sqlWithMacro = Range::orWhereRangeStrictlyLeftOf($this->columnName, $this->range)
            ->orWhereRangeStrictlyLeftOf($this->columnName, $this->range);

        $rawSql = Range::orWhereRaw('? << ?', [$this->columnName, $this->range])
            ->orWhereRaw('? << ?', [$this->columnName, $this->range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function where_range_is_strictly_right_of_by_macro_test(): void
    {
        $sqlWithMacro = Range::whereRangeStrictlyRightOf($this->columnName, $this->range)
            ->whereRangeStrictlyRightOf($this->columnName, $this->range);

        $rawSql = Range::whereRaw('? >> ?', [$this->columnName, $this->range])
            ->whereRaw('? >> ?', [$this->columnName, $this->range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function or_where_range_strictly_right_of_by_macro_test(): void
    {
        $sqlWithMacro = Range::orWhereRangeStrictlyRightOf($this->columnName, $this->range)
            ->orWhereRangeStrictlyRightOf($this->columnName, $this->range);

        $rawSql = Range::orWhereRaw('? >> ?', [$this->columnName, $this->range])
            ->orWhereRaw('? >> ?', [$this->columnName, $this->range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function where_range_does_not_extend_to_the_right_of_macro_test(): void
    {
        $sqlWithMacro = Range::whereRangeDoesNotExtendToTheRightOf($this->columnName, $this->range)
            ->whereRangeDoesNotExtendToTheRightOf($this->columnName, $this->range);

        $rawSql = Range::whereRaw('? &< ?', [$this->columnName, $this->range])
            ->whereRaw('? &< ?', [$this->columnName, $this->range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function or_where_does_not_extend_to_the_right_of_macro_test(): void
    {
        $sqlWithMacro = Range::orWhereRangeDoesNotExtendToTheRightOf($this->columnName, $this->range)
            ->orWhereRangeDoesNotExtendToTheRightOf($this->columnName, $this->range);

        $rawSql = Range::orWhereRaw('? &< ?', [$this->columnName, $this->range])
            ->orWhereRaw('? &< ?', [$this->columnName, $this->range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function where_range_does_not_extend_to_the_left_of_macro_test(): void
    {
        $sqlWithMacro = Range::whereRangeDoesNotExtendToTheLeftOf($this->columnName, $this->range)
            ->whereRangeDoesNotExtendToTheLeftOf($this->columnName, $this->range);

        $rawSql = Range::whereRaw('? &> ?', [$this->columnName, $this->range])
            ->whereRaw('? &> ?', [$this->columnName, $this->range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function or_where_range_does_not_extend_to_the_left_of_macro_test(): void
    {
        $sqlWithMacro = Range::orWhereRangeDoesNotExtendToTheLeftOf($this->columnName, $this->range)
            ->orWhereRangeDoesNotExtendToTheLeftOf($this->columnName, $this->range);

        $rawSql = Range::orWhereRaw('? &> ?', [$this->columnName, $this->range])
            ->orWhereRaw('? &> ?', [$this->columnName, $this->range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function where_range_adjacent_to_macro_test(): void
    {
        $sqlWithMacro = Range::whereRangeAdjacentTo($this->columnName, $this->range)
            ->whereRangeAdjacentTo($this->columnName, $this->range);

        $rawSql = Range::whereRaw('? -|- ?', [$this->columnName, $this->range])
            ->whereRaw('? -|- ?', [$this->columnName, $this->range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    /** @test */
    public function or_where_range_adjacent_to_macro_test(): void
    {
        $sqlWithMacro = Range::orWhereRangeAdjacentTo($this->columnName, $this->range)
            ->orWhereRangeAdjacentTo($this->columnName, $this->range);

        $rawSql = Range::orWhereRaw('? -|- ?', [$this->columnName, $this->range])
            ->orWhereRaw('? -|- ?', [$this->columnName, $this->range]);

        $this->assertEquals($sqlWithMacro->toSql(), $rawSql->toSql());
        $this->assertEquals($sqlWithMacro->getBindings(), $rawSql->getBindings());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->range = new IntegerRange(10, 11);
    }
}
