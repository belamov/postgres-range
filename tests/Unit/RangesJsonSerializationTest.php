<?php

namespace Belamov\PostgresRange\Tests\Unit;

use Belamov\PostgresRange\Ranges\DateRange;
use Belamov\PostgresRange\Ranges\FloatRange;
use Belamov\PostgresRange\Ranges\IntegerRange;
use Belamov\PostgresRange\Ranges\TimeRange;
use Belamov\PostgresRange\Ranges\TimestampRange;
use Belamov\PostgresRange\Tests\TestCase;
use Carbon\CarbonImmutable;

class RangesJsonSerializationTest extends TestCase
{
    /** @test */
    public function timestamp_range_json_serializes_correctly(): void
    {
        $range = new TimestampRange('2010-01-01 14:30:30', '2010-01-01 15:30:30', '[', ']');
        $this->assertEquals('"[\"2010-01-01 14:30:30\",\"2010-01-01 15:30:30\"]"', json_encode($range));

        $range = new TimestampRange('2010-01-01 14:30:30', '2010-01-01 15:30:30', '(', ']');
        $this->assertEquals('"(\"2010-01-01 14:30:30\",\"2010-01-01 15:30:30\"]"', json_encode($range));

        $range = new TimestampRange('2010-01-01 14:30:30', '2010-01-01 15:30:30', '(', ')');
        $this->assertEquals('"(\"2010-01-01 14:30:30\",\"2010-01-01 15:30:30\")"', json_encode($range));

        $range = new TimestampRange(null, '2010-01-01 15:30:30', '[', ']');
        $this->assertEquals('"[,\"2010-01-01 15:30:30\"]"', json_encode($range));

        $range = new TimestampRange('2010-01-01 14:30:30', null, '[', ']');
        $this->assertEquals('"[\"2010-01-01 14:30:30\",]"', json_encode($range));

        $range = new TimestampRange(null, null, '[', ']');
        $this->assertEquals('"[,]"', json_encode($range));
    }

    /** @test */
    public function time_range_json_serializes_correctly(): void
    {
        $range = new TimeRange('14:30', '15:30', '[', ']');
        $this->assertEquals('"[14:30,15:30]"', json_encode($range));

        $range = new TimeRange('14:30', '15:30', '(', ']');
        $this->assertEquals('"(14:30,15:30]"', json_encode($range));

        $range = new TimeRange('14:30', '15:30', '(', ')');
        $this->assertEquals('"(14:30,15:30)"', json_encode($range));

        $range = new TimeRange(null, '15:30', '[', ']');
        $this->assertEquals('"[,15:30]"', json_encode($range));

        $range = new TimeRange('14:30', null, '[', ']');
        $this->assertEquals('"[14:30,]"', json_encode($range));

        $range = new TimeRange(null, null, '[', ']');
        $this->assertEquals('"[,]"', json_encode($range));
    }

    /** @test */
    public function numeric_range_json_serializes_correctly(): void
    {
        $range = new FloatRange(1.5, 2.5, '[', ']');
        $this->assertEquals('"[1.5,2.5]"', json_encode($range));

        $range = new FloatRange(1.5, 2.5, '(', ']');
        $this->assertEquals('"(1.5,2.5]"', json_encode($range));

        $range = new FloatRange(1.5, 2.5, '(', ')');
        $this->assertEquals('"(1.5,2.5)"', json_encode($range));

        $range = new FloatRange(null, 2.5, '[', ']');
        $this->assertEquals('"[,2.5]"', json_encode($range));

        $range = new FloatRange(1.5, null, '[', ']');
        $this->assertEquals('"[1.5,]"', json_encode($range));

        $range = new FloatRange(null, null, '[', ']');
        $this->assertEquals('"[,]"', json_encode($range));
    }

    /** @test */
    public function integer_range_json_serializes_correctly(): void
    {
        $range = new IntegerRange(10, 20, '[', ']');
        $this->assertEquals('"[10,21)"', json_encode($range));

        $range = new IntegerRange(10, 20, '(', ']');
        $this->assertEquals('"[11,21)"', json_encode($range));

        $range = new IntegerRange(10, 20, '(', ')');
        $this->assertEquals('"[11,20)"', json_encode($range));

        $range = new IntegerRange(null, 20, '[', ']');
        $this->assertEquals('"[,21)"', json_encode($range));

        $range = new IntegerRange(null, 20, '(', ']');
        $this->assertEquals('"[,21)"', json_encode($range));

        $range = new IntegerRange(10, null, '[', ']');
        $this->assertEquals('"[10,)"', json_encode($range));

        $range = new IntegerRange(null, null, '[', ']');
        $this->assertEquals('"[,)"', json_encode($range));
    }

    /** @test */
    public function date_range_json_serializes_correctly(): void
    {
        $from = CarbonImmutable::parse('2010-01-10');
        $to = CarbonImmutable::parse('2010-01-15');
        $range = new DateRange($from->toDateString(), $to->toDateString(), '[', ']');
        $this->assertEquals("\"[{$from->toDateString()},{$to->addDay()->toDateString()})\"", json_encode($range));

        $range = new DateRange($from->toDateString(), $to->toDateString(), '(', ']');
        $this->assertEquals("\"[{$from->addDay()->toDateString()},{$to->addDay()->toDateString()})\"", json_encode($range));

        $range = new DateRange($from->toDateString(), $to->toDateString(), '(', ')');
        $this->assertEquals("\"[{$from->addDay()->toDateString()},{$to->toDateString()})\"", json_encode($range));

        $range = new DateRange(null, $to->toDateString(), '[', ']');
        $this->assertEquals("\"[,{$to->addDay()->toDateString()})\"", json_encode($range));

        $range = new DateRange(null, $to->toDateString(), '(', ']');
        $this->assertEquals("\"[,{$to->addDay()->toDateString()})\"", json_encode($range));

        $range = new DateRange($from->toDateString(), null, '[', ']');
        $this->assertEquals("\"[{$from->toDateString()},)\"", json_encode($range));

        $range = new DateRange(null, null, '[', ']');
        $this->assertEquals('"[,)"', json_encode($range));
    }
}
