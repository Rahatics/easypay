<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // মার্চেন্টের সাথে লিংক
            $table->string('order_id')->unique(); // আপনার নিজের তৈরি ইউনিক অর্ডার আইডি
            $table->decimal('amount', 10, 2);
            $table->decimal('processing_fee', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->string('currency')->default('BDT');
            $table->string('description')->nullable();
            $table->json('customer_info')->nullable(); // JSON এ কাস্টমারের তথ্য রাখতে পারেন
            $table->string('status')->default('pending'); // যেমন: pending, processing, completed, failed, cancelled
            $table->string('gateway'); // যেমন: 'bkash', 'nagad'
            $table->string('transaction_id')->nullable(); // গেটওয়ের ট্রানজেকশন আইডি
            $table->string('callback_url')->nullable(); // মার্চেন্টের কলব্যাক ইউআরএল
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
