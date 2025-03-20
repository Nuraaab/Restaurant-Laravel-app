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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('slug')->unique();
            $table->boolean('status')->default(1);
            $table->boolean('featured')->default(0);
            $table->enum('discount_type', ['percentage', 'fixed'])->nullable();
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->date('discount_start_date')->nullable();
            $table->date('discount_end_date')->nullable();
            $table->decimal('price', 10, 2);
            $table->boolean('flash')->default(0);
            $table->string('tag')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
