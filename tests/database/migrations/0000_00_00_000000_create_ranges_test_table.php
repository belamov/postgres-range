<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRangesTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('ranges', static function (Blueprint $table) {
            $table->id();
        });

        Belamov\PostrgesRange\PostrgesRangeFacade::timestampRange('ranges', 'timestamp_range', true);
        Belamov\PostrgesRange\PostrgesRangeFacade::timeRange('ranges', 'time_range', true);
        Belamov\PostrgesRange\PostrgesRangeFacade::numberRange('ranges', 'float_range', true);
        Belamov\PostrgesRange\PostrgesRangeFacade::integerRange('ranges', 'integer_range', true);
        Belamov\PostrgesRange\PostrgesRangeFacade::bigintRange('ranges', 'bigint_range', true);
        Belamov\PostrgesRange\PostrgesRangeFacade::dateRange('ranges', 'date_range', true);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('ranges');
    }
}
