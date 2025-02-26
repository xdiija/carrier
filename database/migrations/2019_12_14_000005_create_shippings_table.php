<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('recipient_id');
            $table->unsignedBigInteger('posting_point_id');
            $table->string('tracking_code');
            $table->tinyInteger('status')->default(1);
            $table->timestamp('estimated_delivery');
            $table->timestamp('actual_delivery')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')->onDelete('cascade');
            $table->foreign('sender_id')
                ->references('id')->on('senders')->onDelete('cascade');
            $table->foreign('recipient_id')
                ->references('id')->on('recipients')->onDelete('cascade');
            $table->foreign('posting_point_id')
                ->references('id')->on('posting_points')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('shippings');
    }
};