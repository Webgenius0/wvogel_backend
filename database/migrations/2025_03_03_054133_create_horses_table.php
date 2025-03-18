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
        Schema::create('horses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id'); // Foreign key referencing categories table
            $table->string('name');
            $table->text('about_horse')->nullable(); // Optional field
            $table->string('horse_image')->nullable(); // Optional field
            $table->integer('racing_start')->default(0);
            $table->integer('racing_win')->default(0);
            $table->integer('racing_place')->default(0);
            $table->integer('racing_show')->default(0);
            $table->string('breed');
            $table->string('gender');
            $table->string('age');
            $table->string('trainer');
            $table->string('owner');
            $table->integer('price')->default(0);
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade'); // Add foreign key constraint to categories table using Laravel's migration syntax. This ensures data integrity and prevents orphaned records.

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horses');
    }
};
