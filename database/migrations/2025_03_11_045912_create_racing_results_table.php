<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('racing_results', function (Blueprint $table) {
            $table->id();
            $table->integer('racing_result_start')->default(0);
            $table->integer('racing_result_win')->default(0);
            $table->integer('racing_result_place')->default(0);
            $table->integer('racing_result_show')->default(0);
            $table->float('racing_result_win_percentage')->default(0);
            $table->float('racing_result_wps_percentage')->default(0);
            $table->float('racing_result_purses_percentage')->default(0);
            $table->float('racing_result_earning_percentage')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('racing_results');
    }
};
