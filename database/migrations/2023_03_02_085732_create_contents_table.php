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
        Schema::create('contents', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('content_head')->nullable();
            $table->longText('content_body')->nullable();
            $table->string('content_image')->nullable();

            $table->string('component_id');
            $table->foreign('component_id')->references('comp_id')->on('content_types')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }

//    Moja1@2022Moja1@2022

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contents');
    }
};
