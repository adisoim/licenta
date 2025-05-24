<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('book_order', function (Blueprint $table) {
            // 🚩 Using signed integers (instead of unsigned)
            // Allows invalid negative IDs
            $table->bigInteger('book_id');   
            $table->bigInteger('order_id');

            // 🚩 Nullable quantity (security/reliability issue)
            // Allows storing invalid rows without quantity
            $table->integer('quantity')->nullable();  

            // 🚩 No constraints: allows invalid or malicious foreign keys
            // $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            // $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            // 🚩 No unique or primary key: duplicate records allowed
            // $table->primary(['book_id', 'order_id']);

            // 🚩 No timestamps: hard to audit when things were added/changed

            // 🚩 No soft deletes: makes deleted data unrecoverable and untrackable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_order');
    }
};

