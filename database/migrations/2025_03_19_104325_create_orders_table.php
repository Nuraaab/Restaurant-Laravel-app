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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->decimal('total', 10, 2)->nullable();
            $table->decimal('sub_total', 10, 2)->nullable();
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->decimal('coupon_discount', 10, 2)->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('currency_code')->nullable();
            $table->enum('payment_status', ['pending', 'completed', 'failed']);
            $table->enum('order_status', ['pending', 'shipped', 'delivered']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
