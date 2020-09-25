<?php

namespace Belamov\PostgresRange\Tests\Unit;

use Belamov\PostgresRange\Ranges\FloatRange;
use Belamov\PostgresRange\Ranges\IntegerRange;
use Belamov\PostgresRange\Tests\TestCase;
use CreateRangesAdditionalTestTable;
use CreateRangesTestTable;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class SqlGenerationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_nullable_columns(): void
    {
        $model = $this->createModel([]);

        $model = $model->fresh();

        $this->assertNull($model->timestamp_range_nullable);
        $this->assertNull($model->timestamptz_range_nullable);
        $this->assertNull($model->time_range_nullable);
        $this->assertNull($model->float_range_nullable);
        $this->assertNull($model->integer_range_nullable);
        $this->assertNull($model->bigint_range_nullable);
        $this->assertNull($model->date_range_nullable);
    }

    /** @test */
    public function it_creates_columns_with_default_values(): void
    {
        $model = $this->createModel([]);

        $model = $model->fresh();

        $this->assertEquals(
            '["2010-01-01 14:30:30","2010-01-02 14:30:30")',
            $model->getRawOriginal('timestamp_range_with_default')
        );
        $this->assertEquals(
            '["2010-01-01 16:30:30+00","2010-01-02 16:30:30+00")',
            $model->getRawOriginal('timestamptz_range_with_default')
        );
        $this->assertEquals('[14:30:30,15:30:30)', $model->getRawOriginal('time_range_with_default'));
        $this->assertEquals('[1.5,2.5)', $model->getRawOriginal('float_range_with_default'));
        $this->assertEquals('[10,20)', $model->getRawOriginal('integer_range_with_default'));
        $this->assertEquals('[10,20)', $model->getRawOriginal('bigint_range_with_default'));
        $this->assertEquals('[2010-01-01,2010-01-02)', $model->getRawOriginal('date_range_with_default'));
    }

    /** @test */
    public function it_creates_indexes(): void
    {
        $indexes = DB::select(
            "
            SELECT
                indexname,
                indexdef
            FROM
                pg_indexes
            WHERE
                tablename = 'ranges';
        "
        );

        $this->assertEquals(
            'ranges_time_range_with_default_spatialindex',
            $indexes[1]->indexname
        );

        $this->assertEquals(
            'CREATE INDEX ranges_time_range_with_default_spatialindex ON public.ranges USING gist (time_range_with_default)',
            $indexes[1]->indexdef
        );
    }

    /** @test */
    public function it_generates_unique_constraints(): void
    {
        $this->expectException(QueryException::class);
        $this->expectExceptionMessageMatches('/conflicting key value violates exclusion constraint/');
        $this->expectExceptionMessageMatches('/bigint_range_nullable/');

        $integerRange = new IntegerRange(1, 2);
        $this->createModel(['bigint_range_nullable' => $integerRange]);
        $this->createModel(['bigint_range_nullable' => $integerRange]);
    }

    /** @test */
    public function it_generates_unique_constraints_with_additional_column(): void
    {
        $this->expectException(QueryException::class);
        $this->expectExceptionMessageMatches('/conflicting key value violates exclusion constraint/');
        $this->expectExceptionMessageMatches('/(column1, integer_range_nullable)/');

        $integerRange = new IntegerRange(1, 2);
        $this->createModel(['integer_range_nullable' => $integerRange, 'column1' => 1]);
        $this->createModel(['integer_range_nullable' => $integerRange, 'column1' => 1]);
    }

    /** @test */
    public function it_generates_unique_constraints_with_additional_columns(): void
    {
        $this->expectException(QueryException::class);
        $this->expectExceptionMessageMatches('/conflicting key value violates exclusion constraint/');
        $this->expectExceptionMessageMatches('/(column1, column2, column3, float_range_nullable)/');

        $integerRange = new FloatRange(1, 2);

        $this->createModel(
            ['float_range_nullable' => $integerRange, 'column1' => 1, 'column2' => 2]
        );
        $duplicatedModel = $this->createModel(
            ['float_range_nullable' => $integerRange, 'column1' => 1, 'column2' => 2]
        );
        $this->assertNotEmpty($duplicatedModel->id);

        $this->createModel(
            ['float_range_nullable' => $integerRange, 'column1' => 1, 'column2' => 2, 'column3' => 3]
        );
        $this->createModel(
            ['float_range_nullable' => $integerRange, 'column1' => 1, 'column2' => 2, 'column3' => 3]
        );
    }

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMockingConsoleOutput();

        include_once __DIR__.'/../database/migrations/0000_00_00_000000_create_ranges_test_table.php';
        include_once __DIR__.'/../database/migrations/0000_00_00_000001_create_ranges_additional_test_table.php';

        // run the up() method of that migration class
        (new CreateRangesTestTable())->up();
        (new CreateRangesAdditionalTestTable())->up();
    }
}
