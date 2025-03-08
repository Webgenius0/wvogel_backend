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
        Schema::create('horse_share_for_sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('horse_id');
            $table->unsignedBigInteger('category_id');
            $table->string('ownership_share');
            $table->integer('sub_total_price');
            $table->integer('total_price');
            $table->string('paypal_payment_id')->nullable();
            $table->string('approval_url')->nullable();
            $table->enum('status', ['pending', 'success'])->default('pending');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('horse_id')->references('id')->on('horses')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horse_share_for_sales');
    }
};
