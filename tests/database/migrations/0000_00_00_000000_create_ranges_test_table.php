<?php

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
                $table->timestampRange('timestamp_range')->nullable();
                $table->timeRange('time_range')->nullable();
                $table->floatRange('float_range')->nullable();
                $table->integerRange('integer_range')->nullable();
                $table->bigIntegerRange('bigint_range')->nullable();
                $table->dateRange('date_range')->nullable();
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
