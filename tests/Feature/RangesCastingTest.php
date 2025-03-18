<?php

namespace Belamov\PostgresRange\Tests\Feature;

use Belamov\PostgresRange\Ranges\DateRange;
use Belamov\PostgresRange\Ranges\FloatRange;
use Belamov\PostgresRange\Ranges\IntegerRange;
use Belamov\PostgresRange\Ranges\TimeRange;
use Belamov\PostgresRange\Ranges\TimestampRange;
use Belamov\PostgresRange\Tests\TestCase;
use Carbon\CarbonImmutable;
use CreateRangesAdditionalTestTable;
use CreateRangesTestTable;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RangesCastingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_casts_timestamp_range_column(): void
    {
        $from = '2010-01-01 14:30:30';
        $to = '2010-01-01 15:30:30';
        $timestampRange = new TimestampRange($from, $to, '[', ']');
        $model = $this->createModel(
            [
                'timestamp_range' => $timestampRange,
            ]
        );

        $model = $model->fresh();

        $this->assertDatabaseHas('ranges', ['id' => $model->id]);
        $this->assertInstanceOf(TimestampRange::class, $model->timestamp_range);
        $this->assertEquals($from, $model->timestamp_range->from()->toDateTimeString());
        $this->assertEquals($to, $model->timestamp_range->to()->toDateTimeString());
    }

    /** @test */
    public function it_does_not_detect_changes_when_updating_with_same_timestamp_range(): void
    {
        $from = '2010-01-01 14:30:30';
        $to = '2010-01-01 15:30:30';
        $timestampRange = new TimestampRange($from, $to, '[', ']');
        $model = $this->createModel(
            [
                'timestamp_range' => $timestampRange,
            ]
        );

        $model = $model->fresh();
        $model->update(
            [
                'timestamp_range' => $timestampRange,
            ]
        );

        $this->assertEmpty($model->getChanges());
    }

    /** @test */
    public function it_casts_timestamptz_range_column(): void
    {
        $from = '2010-01-01 14:30:30-2:00';
        $to = '2010-01-01 15:30:30-2:00';
        $timestampRange = new TimestampRange($from, $to, '[', ']');
        $model = $this->createModel(
            [
                'timestamptz_range' => $timestampRange,
            ]
        );

        $model = $model->fresh();

        $this->assertDatabaseHas('ranges', ['id' => $model->id]);
        $this->assertInstanceOf(TimestampRange::class, $model->timestamptz_range);
        $this->assertEquals(CarbonImmutable::parse($from)->timezone('UTC')->toDateTimeString(), $model->timestamptz_range->from()->toDateTimeString());
        $this->assertEquals(CarbonImmutable::parse($to)->timezone('UTC')->toDateTimeString(), $model->timestamptz_range->to()->toDateTimeString());
    }

    /** @test */
    public function it_casts_time_range_column(): void
    {
        $from = '14:30:30';
        $to = '15:30:30';
        $timeRange = new TimeRange($from, $to, '[', ']');
        $model = $this->createModel(
            [
                'time_range' => $timeRange,
            ]
        );

        $model = $model->fresh();

        $this->assertDatabaseHas('ranges', ['id' => $model->id]);
        $this->assertInstanceOf(TimeRange::class, $model->time_range);
        $this->assertEquals($from, $model->time_range->from());
        $this->assertEquals($to, $model->time_range->to());
    }

    /** @test */
    public function it_casts_date_range_column(): void
    {
        $from = CarbonImmutable::parse('2010-01-10');
        $to = CarbonImmutable::parse('2010-01-15');
        $dateRange = new DateRange($from->toDateString(), $to->toDateString(), '[', ')');
        $model = $this->createModel(
            [
                'date_range' => $dateRange,
            ]
        );

        $model = $model->fresh();

        $this->assertDatabaseHas('ranges', ['id' => $model->id]);
        $this->assertInstanceOf(DateRange::class, $model->date_range);
        $this->assertEquals('[', $model->date_range->fromBound());
        $this->assertEquals(')', $model->date_range->toBound());
        $this->assertEquals($from, $model->date_range->from());
        $this->assertEquals($to, $model->date_range->to());
    }

    /** @test */
    public function it_casts_float_range_column(): void
    {
        $from = 1.5;
        $to = 2.5;
        $floatRange = new FloatRange($from, $to, '[', ']');
        $model = $this->createModel(
            [
                'float_range' => $floatRange,
            ]
        );

        $model = $model->fresh();

        $this->assertDatabaseHas('ranges', ['id' => $model->id]);
        $this->assertInstanceOf(FloatRange::class, $model->float_range);
        $this->assertEquals('[', $model->float_range->fromBound());
        $this->assertEquals(']', $model->float_range->toBound());
        $this->assertEquals($from, $model->float_range->from());
        $this->assertEquals($to, $model->float_range->to());
    }

    /** @test */
    public function it_casts_integer_and_bigint_range_column(): void
    {
        $from = 10;
        $to = 20;
        $integerRange = new IntegerRange($from, $to, '[', ')');
        $model = $this->createModel(
            [
                'integer_range' => $integerRange,
                'bigint_range' => $integerRange,
            ]
        );

        $model = $model->fresh();

        $this->assertDatabaseHas('ranges', ['id' => $model->id]);

        $this->assertInstanceOf(IntegerRange::class, $model->integer_range);
        $this->assertEquals('[', $model->integer_range->fromBound());
        $this->assertEquals(')', $model->integer_range->toBound());
        $this->assertEquals($from, $model->integer_range->from());
        $this->assertEquals($to, $model->integer_range->to());

        $this->assertInstanceOf(IntegerRange::class, $model->bigint_range);
        $this->assertEquals('[', $model->bigint_range->fromBound());
        $this->assertEquals(')', $model->bigint_range->toBound());
        $this->assertEquals($from, $model->bigint_range->from());
        $this->assertEquals($to, $model->bigint_range->to());
    }

    /** @test */
    public function it_casts_empty_values_to_null(): void
    {
        $model = $this->createModel(
            [
                'timestamp_range' => null,
                'time_range' => null,
                'float_range' => null,
                'integer_range' => null,
                'bigint_range' => null,
                'date_range' => null,
            ]
        );

        $model = $model->fresh();

        $this->assertNull($model->timestamp_range);
        $this->assertNull($model->time_range);
        $this->assertNull($model->float_range);
        $this->assertNull($model->integer_range);
        $this->assertNull($model->bigint_range);
        $this->assertNull($model->date_range);
    }

    /** @test */
    public function it_casts_empty_boundaries_to_null(): void
    {
        $rangeFields = [
            'timestamp_range',
            'time_range',
            'float_range',
            'integer_range',
            'bigint_range',
            'date_range',
        ];

        $modelWithMissingLowerBoundary = $this->createModel(
            [
                'timestamp_range' => new TimestampRange(null, '2010-01-01 14:30:30'),
                'time_range' => new TimeRange(null, '10:30'),
                'float_range' => new FloatRange(null, 2.5),
                'integer_range' => new IntegerRange(null, 10),
                'bigint_range' => new IntegerRange(null, 10),
                'date_range' => new DateRange(null, '2010-01-01'),
            ]
        );

        $modelWithMissingLowerBoundary = $modelWithMissingLowerBoundary->fresh();

        foreach ($rangeFields as $field) {
            $this->assertNull($modelWithMissingLowerBoundary->$field->from());
            $this->assertFalse($modelWithMissingLowerBoundary->$field->hasLowerBoundary());
            $this->assertTrue($modelWithMissingLowerBoundary->$field->hasUpperBoundary());
        }

        $modelWithMissingUpperBoundary = $this->createModel(
            [
                'timestamp_range' => new TimestampRange('2010-01-01 14:30:30', null),
                'time_range' => new TimeRange('10:30', null),
                'float_range' => new FloatRange(2.5, null),
                'integer_range' => new IntegerRange(10, null),
                'bigint_range' => new IntegerRange(10, null),
                'date_range' => new DateRange('2010-01-01', null),
            ]
        );

        $modelWithMissingUpperBoundary = $modelWithMissingUpperBoundary->fresh();

        foreach ($rangeFields as $field) {
            $this->assertNull($modelWithMissingUpperBoundary->$field->to());
            $this->assertTrue($modelWithMissingUpperBoundary->$field->hasLowerBoundary());
            $this->assertFalse($modelWithMissingUpperBoundary->$field->hasUpperBoundary());
        }
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
