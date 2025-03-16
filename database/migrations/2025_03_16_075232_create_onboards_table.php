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
        Schema::create('onboards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('most_share_race_horse')->nullable();
            $table->string('roi')->nullable();
            $table->string('horse_racing_risk_ownership')->nullable();
            $table->string('investment_opportunities')->nullable();
            $table->string('investment_venture')->nullable();
            $table->string('investment_venture_book')->nullable();
            $table->string('racing_potiential_profit')->nullable();
            $table->string('passive_investment')->nullable();
            $table->string('younger_experience')->nullable();
            $table->string('race_entery_fees')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('onboards');
    }
};
