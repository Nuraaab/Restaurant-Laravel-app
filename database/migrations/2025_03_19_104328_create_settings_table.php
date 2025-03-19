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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->text('receipt_footer');
            $table->text('receipt_header');
            $table->text('receipt_stamp');
            $table->string('currency');
            $table->string('logo');
            $table->string('primary_color');
            $table->string('secondary_color');
            $table->string('sender_email');
            $table->string('sender_name');
            $table->text('map_link');
            $table->decimal('tax', 10, 2);
            $table->string('restaurant_name');
            $table->decimal('delivery_charge', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
