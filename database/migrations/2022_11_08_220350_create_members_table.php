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
        Schema::create('members', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('address');
            $table->dateTime('dob');
            $table->boolean('status')->default(false);
//            $table->string('occupation');
            $table->unsignedBigInteger('occupation_id');
            $table->string('role');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phoneNumber')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('occupation_id')->references('id')->on('skills')->onDelete('cascade')->onUpdate('cascade');
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
};
