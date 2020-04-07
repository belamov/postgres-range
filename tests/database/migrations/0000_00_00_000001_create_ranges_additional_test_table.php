<?php

use Belamov\PostgresRange\SqlGenerator;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRangesAdditionalTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table(
            'ranges',
            static function (Blueprint $table) {
                $table->integer('column1')->nullable();
                $table->integer('column2')->nullable();
                $table->integer('column3')->nullable();
            }
        );

        $sqlGenerator = new SqlGenerator('ranges');

        $sqlGenerator->timestampRange('timestamp_range_nullable', true);
        $sqlGenerator->timeRange('time_range_nullable', true);
        $sqlGenerator->numberRange('float_range_nullable', true);
        $sqlGenerator->integerRange('integer_range_nullable', true);
        $sqlGenerator->bigintRange('bigint_range_nullable', true);
        $sqlGenerator->dateRange('date_range_nullable', true);

        $sqlGenerator->timestampRange(
            'timestamp_range_with_default',
            false,
            '[2010-01-01 14:30:30,2010-01-02 14:30:30)'
        );
        $sqlGenerator->timeRange('time_range_with_default', false, '[14:30:30,15:30:30)');
        $sqlGenerator->numberRange('float_range_with_default', false, '[1.5,2.5)');
        $sqlGenerator->integerRange('integer_range_with_default', false, '[10,20)');
        $sqlGenerator->bigintRange('bigint_range_with_default', false, '[10,20)');
        $sqlGenerator->dateRange('date_range_with_default', false, '[2010-01-01,2010-01-02)');

        $sqlGenerator->gistIndex('time_range_with_default');

        $sqlGenerator->unique('bigint_range_nullable');
        $sqlGenerator->unique('integer_range_nullable', 'column1');
        $sqlGenerator->unique('float_range_nullable', 'column1', 'column2', 'column3');
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
