<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('referee_id')->unsigned();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('sex');
            $table->string('date_of_birth');
            $table->string('email');
            $table->string('phone');
            $table->string('photo')->nullable();
            $table->string('username');
            $table->string('password');
            $table->string('verification_token');
            $table->string('status')->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
