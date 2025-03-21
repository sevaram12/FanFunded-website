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
        Schema::create('paypal_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('paypal_payment_id')->nullable();
            $table->string('amount')->nullable();
            $table->string('currency')->nullable();
            $table->string('phase')->nullable();
            $table->string('account_size')->nullable();
            $table->string('challenge_fees')->nullable();
            $table->string('your_balance')->nullable();
            $table->string('minimum_picks')->nullable();
            $table->string('minimum_picks_amount')->nullable();
            $table->string('maximum_picks_amount')->nullable();
            $table->string('maximum_loss')->nullable();
            $table->string('maximum_daily_loss')->nullable();
            $table->string('profit_target')->nullable();
            $table->string('time_limit')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('challenge_status')->default('Active')->nullable();
            $table->string('payment_status')->default('Pending')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
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
        Schema::dropIfExists('paypal_payments');
    }
};
