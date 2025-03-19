<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bettings', function (Blueprint $table) {
            $table->id();
            $table->string('bet_id'); // Unique bet ID from API
            $table->string('sport_key');
            $table->string('sport')->nullable();
            $table->string('price')->nullable(); // odds
            $table->string('sport_title');
            $table->dateTime('commence_time');
            $table->string('home_team');
            $table->string('away_team');
            $table->string('your_bet_team')->nullable();
            $table->string('bookmaker_key'); // Bookmaker identifier
            $table->string('bookmaker_title'); // Bookmaker name
            $table->string('type'); // Bet type (Moneyline, Spread, Totals)
            $table->string('team')->nullable(); // Team name (if applicable)
            $table->decimal('pick', 8, 2)->nullable();
            $table->decimal('to_win', 8, 2)->nullable();
            $table->enum('bet_type', ['straight', 'parlay']); // Indicates whether it's a straight or parlay bet
            $table->decimal('total_collect', 10, 2)->nullable(); // Total collect value for each bet type
            $table->string('match_status')->default('Active')->nullable();
            $table->unsignedBigInteger('user_id'); // User placing the bet
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bettings');
    }
};
