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
        Schema::create('member_timelines', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('old_occupation_id');
            $table->unsignedBigInteger('new_occupation_id');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('old_occupation_id')->references('id')->on('skills')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('new_occupation_id')->references('id')->on('skills')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('member_timelines');
    }
};
