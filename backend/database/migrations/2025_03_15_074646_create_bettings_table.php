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
            $table->string('user_id')->nullable();
            $table->string('straight_bets')->nullable();
            $table->string('parlay_bets')->nullable();
            $table->string('total_collect')->nullable();
            $table->timestamps();
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
