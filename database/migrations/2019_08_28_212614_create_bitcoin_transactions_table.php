<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitcoinTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bitcoin_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('bitcoin_account_id')->unsigned();
            $table->string('transaction_id');
            $table->string('transaction_type');
            $table->double('amount');
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('bitcoin_transactions');
    }
}
