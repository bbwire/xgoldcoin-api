<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateXgoldTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xgold_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('xgold_account_id')->unsigned();
            $table->string('transaction_id');
            $table->string('transaction_type');
            $table->double('amount');
            $table->string('status');
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
        Schema::dropIfExists('xgold_transactions');
    }
}
