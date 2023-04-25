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
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wallet_id');
            $table->unsignedBigInteger('bank_id');
            $table->unsignedBigInteger('promoter_id');
            $table->unsignedBigInteger('currency_id');
            $table->unsignedBigInteger('channel_id');
            $table->enum('type', ['deposit', 'withdrawal']);
            $table->decimal('amount', 17, 5);
            $table->decimal('exchange_rate', 17, 5);
            $table->decimal('amount_converted', 17, 5);
            $table->dateTime('date');

            $table->foreign('wallet_id')->references('id')->on('wallets');
            $table->foreign('bank_id')->references('id')->on('banks');
            $table->foreign('promoter_id')->references('id')->on('promoters');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('channel_id')->references('id')->on('channels');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
