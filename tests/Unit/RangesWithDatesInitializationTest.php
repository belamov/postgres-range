<?php

namespace Belamov\PostrgesRange\Tests\Unit;

use Belamov\PostrgesRange\Ranges\DateRange;
use Belamov\PostrgesRange\Ranges\TimeRange;
use Belamov\PostrgesRange\Ranges\TimestampRange;
use Belamov\PostrgesRange\Tests\TestCase;
use Carbon\CarbonImmutable;
use DateTime;
use Exception;

class RangesWithDatesInitializationTest extends TestCase
{
    /** @test
     * @throws Exception
     */
    public function date_range_can_be_initialized_with_strings_or_date_object(): void
    {
        $fromString = '2010-01-10';
        $toString = '2010-01-15';

        $fromCarbon = CarbonImmutable::parse($fromString);
        $toCarbon = CarbonImmutable::parse($toString);

        $fromDateObject = new DateTime($fromString);
        $toDateObject = new DateTime($toString);

        $rangeInitiatedWithStrings = new DateRange($fromString, $toString);
        $rangeInitiatedWithCarbon = new DateRange($fromCarbon, $toCarbon);
        $rangeInitiatedWithDateObject = new DateRange($fromDateObject, $toDateObject);

        $this->assertEquals($rangeInitiatedWithCarbon->from(), $fromCarbon);
        $this->assertEquals($rangeInitiatedWithCarbon->to(), $toCarbon);

        $this->assertEquals($rangeInitiatedWithStrings->from(), $fromCarbon);
        $this->assertEquals($rangeInitiatedWithStrings->to(), $toCarbon);

        $this->assertEquals($rangeInitiatedWithDateObject->from(), $fromCarbon);
        $this->assertEquals($rangeInitiatedWithDateObject->to(), $toCarbon);
    }

    /** @test
     * @throws Exception
     */
    public function timestamp_range_can_be_initialized_with_strings_or_date_object(): void
    {
        $fromString = '2010-01-10 14:30:30';
        $toString = '2010-01-15 15:30:30';

        $fromCarbon = CarbonImmutable::parse($fromString);
        $toCarbon = CarbonImmutable::parse($toString);

        $fromDateObject = new DateTime($fromString);
        $toDateObject = new DateTime($toString);

        $rangeInitiatedWithStrings = new TimestampRange($fromString, $toString);
        $rangeInitiatedWithCarbon = new TimestampRange($fromCarbon, $toCarbon);
        $rangeInitiatedWithDateObject = new TimestampRange($fromDateObject, $toDateObject);

        $this->assertEquals($rangeInitiatedWithCarbon->from(), $fromCarbon);
        $this->assertEquals($rangeInitiatedWithCarbon->to(), $toCarbon);

        $this->assertEquals($rangeInitiatedWithStrings->from(), $fromCarbon);
        $this->assertEquals($rangeInitiatedWithStrings->to(), $toCarbon);

        $this->assertEquals($rangeInitiatedWithDateObject->from(), $fromCarbon);
        $this->assertEquals($rangeInitiatedWithDateObject->to(), $toCarbon);
    }

    /** @test
     * @throws Exception
     */
    public function time_range_can_be_initialized_with_strings_or_date_object(): void
    {
        $fromString = '14:30:30';
        $toString = '15:30';

        $fromCarbon = CarbonImmutable::parse($fromString);
        $toCarbon = CarbonImmutable::parse($toString);

        $fromDateObject = new DateTime($fromString);
        $toDateObject = new DateTime($toString);

        $rangeInitiatedWithStrings = new TimeRange($fromString, $toString);
        $rangeInitiatedWithCarbon = new TimeRange($fromCarbon, $toCarbon);
        $rangeInitiatedWithDateObject = new TimeRange($fromDateObject, $toDateObject);

        $this->assertEquals($rangeInitiatedWithCarbon->from(), $fromCarbon->toTimeString());
        $this->assertEquals($rangeInitiatedWithCarbon->to(), $toCarbon->toTimeString());

        $this->assertEquals($rangeInitiatedWithStrings->from(), $fromCarbon->toTimeString());
        $this->assertEquals($rangeInitiatedWithStrings->to(), $toCarbon->toTimeString());

        $this->assertEquals($rangeInitiatedWithDateObject->from(), $fromCarbon->toTimeString());
        $this->assertEquals($rangeInitiatedWithDateObject->to(), $toCarbon->toTimeString());
    }
}
