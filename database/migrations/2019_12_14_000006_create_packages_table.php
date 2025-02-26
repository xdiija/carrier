<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shipping_id');
            $table->decimal('width', 10, 2);
            $table->decimal('height', 10, 2);
            $table->decimal('length', 10, 2);
            $table->decimal('weight', 10, 2);
            $table->decimal('value', 15, 2);
            $table->timestamps();

            $table->foreign('shipping_id')
                ->references('id')->on('shippings')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('packages');
    }
};