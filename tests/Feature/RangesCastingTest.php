<?php

namespace Belamov\PostrgesRange\Tests\Unit;

use Belamov\PostrgesRange\Models\Range;
use Belamov\PostrgesRange\Ranges\DateRange;
use Belamov\PostrgesRange\Ranges\FloatRange;
use Belamov\PostrgesRange\Ranges\IntegerRange;
use Belamov\PostrgesRange\Ranges\TimeRange;
use Belamov\PostrgesRange\Ranges\TimestampRange;
use Belamov\PostrgesRange\Tests\TestCase;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;

class RangesCastingTest extends TestCase
{

    /** @test */
    public function it_casts_timestamp_range_column()
    {
        $from = '2010-01-01 14:30:30';
        $to = '2010-01-01 15:30:30';
        $timestampRange = new TimestampRange($from, $to, '[', ']');
        $model = Range::create([
            'timestamp_range' => $timestampRange
        ]);

        $model = $model->fresh();

        $this->assertDatabaseHas('ranges', ['id' => $model->id]);
        $this->assertInstanceOf(TimestampRange::class, $model->timestamp_range);
        $this->assertEquals($timestampRange, $model->timestamp_range);
        $this->assertEquals($from, $model->timestamp_range->from()->toDateTimeString());
        $this->assertEquals($to, $model->timestamp_range->to()->toDateTimeString());
    }

    /** @test */
    public function it_casts_time_range_column()
    {
        $from = '14:30:30';
        $to = '15:30:30';
        $timeRange = new TimeRange($from, $to, '[', ']');
        $model = Range::create([
            'time_range' => $timeRange
        ]);

        $model = $model->fresh();

        $this->assertDatabaseHas('ranges', ['id' => $model->id]);
        $this->assertInstanceOf(TimeRange::class, $model->time_range);
        $this->assertEquals($timeRange, $model->time_range);
        $this->assertEquals($from, $model->time_range->from());
        $this->assertEquals($to, $model->time_range->to());
    }

    /** @test */
    public function it_casts_date_range_column()
    {
        $from = CarbonImmutable::parse('2010-01-10');
        $to = CarbonImmutable::parse('2010-01-15');
        $dateRange = new DateRange($from->toDateString(), $to->toDateString(), '[', ')');
        $model = Range::create([
            'date_range' => $dateRange
        ]);

        $model = $model->fresh();

        $this->assertDatabaseHas('ranges', ['id' => $model->id]);
        $this->assertInstanceOf(DateRange::class, $model->date_range);
        $this->assertEquals($dateRange, $model->date_range);
        $this->assertEquals($from, $model->date_range->from());
        $this->assertEquals($to, $model->date_range->to());
    }

    /** @test */
    public function it_casts_float_range_column()
    {
        $from = 1.5;
        $to = 2.5;
        $floatRange = new FloatRange($from, $to, '[', ']');
        $model = Range::create([
            'float_range' => $floatRange
        ]);

        $model = $model->fresh();

        $this->assertDatabaseHas('ranges', ['id' => $model->id]);
        $this->assertInstanceOf(FloatRange::class, $model->float_range);
        $this->assertEquals($floatRange, $model->float_range);
        $this->assertEquals($from, $model->float_range->from());
        $this->assertEquals($to, $model->float_range->to());
    }

    /** @test */
    public function it_casts_integer_and_bigint_range_column()
    {
        $from = 10;
        $to = 20;
        $integerRange = new IntegerRange($from, $to, '[', ')');
        $model = Range::create([
            'integer_range' => $integerRange,
            'bigint_range' => $integerRange
        ]);

        $model = $model->fresh();

        $this->assertDatabaseHas('ranges', ['id' => $model->id]);

        $this->assertInstanceOf(IntegerRange::class, $model->integer_range);
        $this->assertEquals($integerRange, $model->integer_range);
        $this->assertEquals($from, $model->integer_range->from());
        $this->assertEquals($to, $model->integer_range->to());

        $this->assertInstanceOf(IntegerRange::class, $model->bigint_range);
        $this->assertEquals($integerRange, $model->bigint_range);
        $this->assertEquals($from, $model->bigint_range->from());
        $this->assertEquals($to, $model->bigint_range->to());
    }

    /** @test */
    public function it_casts_empty_values_to_null()
    {
//        $model = Range::create([
//            'integer_range' => null,
//            'bigint_range' => null,
//            'float_range' => null,
//            'date_range' => null,
//            'timestamp_range'=>null,
//            'time_range'=>null,
//        ]);
        $model = Range::create();

        $model = $model->fresh();

        $this->assertNull($model->timestamp_range);
        $this->assertNull($model->time_range);
        $this->assertNull($model->float_range);
        $this->assertNull($model->integer_range);
        $this->assertNull($model->bigint_range);
        $this->assertNull($model->date_range);
    }

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMockingConsoleOutput();

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations/');
    }
}
