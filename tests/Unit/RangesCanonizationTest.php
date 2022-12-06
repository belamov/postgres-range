<?php

namespace Belamov\PostgresRange\Tests\Unit;

use Belamov\PostgresRange\Ranges\DateRange;
use Belamov\PostgresRange\Ranges\IntegerRange;
use Belamov\PostgresRange\Tests\TestCase;
use Carbon\CarbonImmutable;

class RangesCanonizationTest extends TestCase
{
    /** @test */
    public function it_canonicalizes_integer_range(): void
    {
        $range = new IntegerRange(10, 20, '(', ')');
        $this->assertEquals(11, $range->from());
        $this->assertEquals(20, $range->to());
        $this->assertEquals('(', $range->fromBound());
        $this->assertEquals(')', $range->toBound());
        $this->assertEquals('[11,20)', (string) $range);

        $range = new IntegerRange(10, 20, '(', ']');
        $this->assertEquals(11, $range->from());
        $this->assertEquals(21, $range->to());
        $this->assertEquals('(', $range->fromBound());
        $this->assertEquals(']', $range->toBound());
        $this->assertEquals('[11,21)', (string) $range);

        $range = new IntegerRange(10, 20, '[', ']');
        $this->assertEquals(10, $range->from());
        $this->assertEquals(21, $range->to());
        $this->assertEquals('[', $range->fromBound());
        $this->assertEquals(']', $range->toBound());
        $this->assertEquals('[10,21)', (string) $range);

        $range = new IntegerRange(10, 20, '[', ')');
        $this->assertEquals(10, $range->from());
        $this->assertEquals(20, $range->to());
        $this->assertEquals('[', $range->fromBound());
        $this->assertEquals(')', $range->toBound());
        $this->assertEquals('[10,20)', (string) $range);

        $range = new IntegerRange(null, 20, '(', ')');
        $this->assertEquals(null, $range->from());
        $this->assertEquals(20, $range->to());
        $this->assertEquals('(', $range->fromBound());
        $this->assertEquals(')', $range->toBound());
        $this->assertEquals('[,20)', (string) $range);

        $range = new IntegerRange(10, null, '[', ']');
        $this->assertEquals(10, $range->from());
        $this->assertEquals(null, $range->to());
        $this->assertEquals('[', $range->fromBound());
        $this->assertEquals(']', $range->toBound());
        $this->assertEquals('[10,)', (string) $range);
    }

    /** @test */
    public function it_canonicalizes_date_range(): void
    {
        $from = CarbonImmutable::parse('2010-01-10');
        $to = CarbonImmutable::parse('2010-01-15');

        $range = new DateRange($from->toDateString(), $to->toDateString(), '(', ')');
        $this->assertEquals($from->addDay(), $range->from());
        $this->assertEquals($to, $range->to());
        $this->assertEquals('(', $range->fromBound());
        $this->assertEquals(')', $range->toBound());
        $this->assertEquals("[{$from->addDay()->toDateString()},{$to->toDateString()})", (string) $range);

        $range = new DateRange($from->toDateString(), $to->toDateString(), '(', ']');
        $this->assertEquals($from->addDay(), $range->from());
        $this->assertEquals($to->addDay(), $range->to());
        $this->assertEquals('(', $range->fromBound());
        $this->assertEquals(']', $range->toBound());
        $this->assertEquals("[{$from->addDay()->toDateString()},{$to->addDay()->toDateString()})", (string) $range);

        $range = new DateRange($from->toDateString(), $to->toDateString(), '[', ']');
        $this->assertEquals($from, $range->from());
        $this->assertEquals($to->addDay(), $range->to());
        $this->assertEquals('[', $range->fromBound());
        $this->assertEquals(']', $range->toBound());
        $this->assertEquals("[{$from->toDateString()},{$to->addDay()->toDateString()})", (string) $range);

        $range = new DateRange($from->toDateString(), $to->toDateString(), '[', ')');
        $this->assertEquals($from, $range->from());
        $this->assertEquals($to, $range->to());
        $this->assertEquals('[', $range->fromBound());
        $this->assertEquals(')', $range->toBound());
        $this->assertEquals("[{$from->toDateString()},{$to->toDateString()})", (string) $range);

        $range = new DateRange(null, $to->toDateString(), '(', ')');
        $this->assertEquals(null, $range->from());
        $this->assertEquals($to, $range->to());
        $this->assertEquals('(', $range->fromBound());
        $this->assertEquals(')', $range->toBound());
        $this->assertEquals("[,{$to->toDateString()})", (string) $range);

        $range = new DateRange($from->toDateString(), null, '[', ']');
        $this->assertEquals($from, $range->from());
        $this->assertEquals(null, $range->to());
        $this->assertEquals('[', $range->fromBound());
        $this->assertEquals(']', $range->toBound());
        $this->assertEquals("[{$from->toDateString()},)", (string) $range);
    }
}
