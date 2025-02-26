<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('posting_points', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('street');
            $table->string('number', 10);
            $table->string('neighborhood');
            $table->string('complement');
            $table->string('city');
            $table->unsignedBigInteger('state_id');
            $table->string('zip_code', 10);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posting_points');
    }
};