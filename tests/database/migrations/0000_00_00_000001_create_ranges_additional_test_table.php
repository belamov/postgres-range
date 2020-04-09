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

                $table->dateRange('date_range_nullable')->nullable();
                $table->dateRange('date_range_with_default')->default('[2010-01-01,2010-01-02)');

                $table->timestampRange('timestamp_range_nullable')->nullable();
                $table->timestampRange('timestamp_range_with_default')->default('[2010-01-01 14:30:30,2010-01-02 14:30:30)');

                $table->floatRange('float_range_nullable')->nullable();
                $table->floatRange('float_range_with_default')->default('[1.5,2.5)');

                $table->integerRange('integer_range_nullable')->nullable();
                $table->integerRange('integer_range_with_default')->default('[10,20)');

                $table->bigIntegerRange('bigint_range_nullable')->nullable();
                $table->bigIntegerRange('bigint_range_with_default')->default('[10,20)');

                $table->timeRange('time_range_nullable')->nullable();
                $table->timeRange('time_range_with_default')->default('[14:30:30,15:30:30)');

                $table->spatialIndex('time_range_with_default');

                $table->uniqueRange('bigint_range_nullable');
                $table->uniqueRange('integer_range_nullable', 'column1');
                $table->uniqueRange('float_range_nullable', 'column1', 'column2', 'column3');
            }
        );
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
