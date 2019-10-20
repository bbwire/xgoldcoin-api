<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateXgoldDirectRewardAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xgold_direct_reward_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('member_id')->unsigned();
            $table->string('account_id');
            $table->double('account_balance');
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
        Schema::dropIfExists('xgold_direct_reward_accounts');
    }
}
