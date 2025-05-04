<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_in', function (Blueprint $table) {
            $table->string('stockin_id')->unique(); // Unique Stock-In ID (e.g., SI001)
            $table->string('item_id'); // Foreign key to items table
            $table->integer('quantity'); // Quantity added to stock
            $table->decimal('price', 10, 2); // Price per unit (auto-filled from items table)
            $table->decimal('total_price', 10, 2); // Total price (calculated as price * quantity)
            $table->date('stockin_date'); // Date of stock-in
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('item_id')->references('item_id')->on('items')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_in');
    }
};