<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_item', function (Blueprint $table) {
            $table->string('room_room_id'); 
            $table->string('item_item_id'); 
            $table->integer('quantity'); 
            $table->timestamps();

            $table->foreign('room_room_id')->references('room_id')->on('rooms')->onDelete('cascade');
            $table->foreign('item_item_id')->references('item_id')->on('items')->onDelete('cascade');

            $table->primary(['room_room_id', 'item_item_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_item');
    }
};