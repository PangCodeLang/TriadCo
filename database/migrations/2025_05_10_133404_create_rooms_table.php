<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->string('room_id')->unique(); 
            $table->string('name'); 
            $table->string('roomtype_id'); 
            $table->string('status')->default('empty'); 
            $table->timestamps();

            $table->foreign('roomtype_id')->references('roomtype_id')->on('room_types')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};