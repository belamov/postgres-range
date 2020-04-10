<?php

namespace Belamov\PostgresRange\Tests\Unit;

use Belamov\PostgresRange\Tests\TestCase;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TimeRangeConfigTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_takes_timerange_type_name_from_config(): void
    {
        $timeRangeTypeName = 'testing_timerange_type_name';
        $timeDiffFunctionName = 'testing_timerange_type_diff_function_name';

        config(['postgres-range.timerange_typename' => $timeRangeTypeName]);
        config(['postgres-range.timerange_subtype_diff_function_name' => $timeDiffFunctionName]);

        Schema::create('testing_config', static function (Blueprint $table) {
            $table->timeRange('timerange');
        });

        $type = DB::select("SELECT * FROM pg_type WHERE typname = '{$timeRangeTypeName}'");
        $this->assertNotEmpty($type);

        $diffFunctionResult = DB::select("
            SELECT {$timeDiffFunctionName}('10:31', '10:30');            
        ");
        $this->assertEquals(60, $diffFunctionResult[0]->{$timeDiffFunctionName});
    }
}
