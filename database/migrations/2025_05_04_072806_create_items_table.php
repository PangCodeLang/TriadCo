<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->string('item_id')->unique(); // Unique item ID
            $table->string('name'); // Item name
            $table->string('category_id'); // Foreign key to item_categories
            $table->integer('in_stock')->default(0); // Renamed from 'quantity' to 'in_stock'
            $table->decimal('price', 10, 2); // Price of the item
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('category_id')->references('itemctgry_id')->on('item_categories')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};