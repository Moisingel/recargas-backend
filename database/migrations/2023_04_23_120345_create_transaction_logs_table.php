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
        Schema::create('transaction_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wallet_transaction_id');
            $table->unsignedBigInteger('promoter_id');
            $table->enum('action', ['CREATE', 'UPDATE', 'DELETE']);
            $table->longText('old_data');
            $table->longText('new_data');
            $table->text('observation')->nullable();

            $table->foreign('wallet_transaction_id')->references('id')->on('wallet_transactions');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_logs');
    }
};
