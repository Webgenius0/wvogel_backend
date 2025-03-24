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
        Schema::create('career_statistics', function (Blueprint $table) {
            $table->id();
            $table->string('starts');
            $table->string('firsts');
            $table->string('seconds');
            $table->string('thirds');
            $table->string('earnings');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_statistics');
    }
};
