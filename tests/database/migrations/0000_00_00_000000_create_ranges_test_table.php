<?php

use Belamov\PostgresRange\SqlGenerator;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;

class CreateRangesTestTable extends Migration
{
    use RefreshDatabase;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(
            'ranges',
            static function (Blueprint $table) {
                $table->id();
            }
        );

        $sqlGenerator = new SqlGenerator('ranges');

        $sqlGenerator->timestampRange('timestamp_range', true);
        $sqlGenerator->timeRange('time_range', true);
        $sqlGenerator->numberRange('float_range', true);
        $sqlGenerator->integerRange('integer_range', true);
        $sqlGenerator->bigintRange('bigint_range', true);
        $sqlGenerator->dateRange('date_range', true);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
    }
}
