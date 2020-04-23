<?php

namespace Belamov\PostgresRange\Tests\Feature;

use Belamov\PostgresRange\Macros\QueryBuilderMacros;
use Belamov\PostgresRange\Models\Range;
use Belamov\PostgresRange\Ranges\DateRange;
use Belamov\PostgresRange\Ranges\FloatRange;
use Belamov\PostgresRange\Ranges\IntegerRange;
use Belamov\PostgresRange\Ranges\TimeRange;
use Belamov\PostgresRange\Ranges\TimestampRange;
use Belamov\PostgresRange\Tests\TestCase;
use Carbon\Carbon;
use CreateRangesTestTable;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MacrosTest extends TestCase
{
    use RefreshDatabase;

    private IntegerRange $range;
    private string $columnName = 'integer_range';

    /** @test */
    public function macros_test(): void
    {
        $macros = new QueryBuilderMacros();

        foreach ($macros->macrosParams as [$method, $operator]) {
            $methodName = "where$method";
            $orMethodName = "orWhere$method";

            $sqlWithMacro = Range::$methodName($this->columnName, $this->range)
                ->$orMethodName($this->columnName, $this->range);

            $rawSql = "select * from \"ranges\" where {$this->columnName} {$operator} {$this->range->forSql()} or {$this->columnName} {$operator} {$this->range->forSql()}";

            $this->assertEquals($sqlWithMacro->toSql(), $rawSql);
        }
    }

    /** @test */
    public function query_builder_macros_do_not_throw_any_exceptions(): void
    {
        $macros = new QueryBuilderMacros();
        $rangeColumns = [
            ['timestamp_range', new TimestampRange(Carbon::now(), Carbon::now()->addDay())],
            ['time_range', new TimeRange('15:30:30', '16:30:30')],
            ['float_range', new FloatRange(1.5, 2.5)],
            ['integer_range', new IntegerRange(10, 20)],
            ['bigint_range', new IntegerRange(10, 20)],
            ['date_range', new DateRange(Carbon::now(), Carbon::now()->addDay())],
        ];

        foreach ($macros->macrosParams as [$macroMethod, $_]) {
            foreach ($rangeColumns as [$columnName, $rangeObject]) {
                $query = "where$macroMethod";

                $items = Range::$query($columnName, $rangeObject)->get();
                $this->assertCount(0, $items);

                $items = Range::$query($rangeObject, $columnName)->get();
                $this->assertCount(0, $items);

                $query = "orWhere$macroMethod";

                $items = Range::$query($columnName, $rangeObject)->get();
                $this->assertCount(0, $items);

                $items = Range::$query($rangeObject, $columnName)->get();
                $this->assertCount(0, $items);
            }
        }
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->range = new IntegerRange(10, 11);

        $this->withoutMockingConsoleOutput();
        include_once __DIR__.'/../database/migrations/0000_00_00_000000_create_ranges_test_table.php';

        // run the up() method of that migration class
        (new CreateRangesTestTable())->up();
    }
}
