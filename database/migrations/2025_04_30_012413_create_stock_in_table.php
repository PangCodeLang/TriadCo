<?php
// filepath: c:\Users\jarma\Documents\TriadCo\TriadCo\database\migrations\2025_04_29_160207_create_stock_in_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockInTable extends Migration
{
    public function up(): void
    {
        Schema::create('stock_in', function (Blueprint $table) {
            $table->string('stockin_id')->primary(); // Custom ID like SI001
            $table->string('supplier_id'); // Foreign key to suppliers table
            $table->unsignedBigInteger('id'); // Foreign key to users table
            $table->date('stock_in_date'); // Date of Stock-In
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('supplier_id')->references('supplier_id')->on('suppliers')->onDelete('cascade');
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_in');
    }
}