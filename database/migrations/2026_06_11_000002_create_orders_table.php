<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('order_number')->unique();
            $table->string('status')->default('confirmed');
            $table->string('payment_method');
            $table->string('payment_status')->default('pending');
            $table->string('customer_name');
            $table->string('customer_email')->default('');
            $table->string('customer_phone');
            $table->text('customer_address');
            $table->string('customer_city');
            $table->unsignedInteger('subtotal');
            $table->unsignedInteger('total');
            $table->string('card_brand')->nullable();
            $table->string('card_last4', 4)->nullable();
            $table->string('card_transaction_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
