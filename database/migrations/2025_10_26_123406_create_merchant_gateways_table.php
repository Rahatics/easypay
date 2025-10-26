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
        Schema::create('merchant_gateways', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // মার্চেন্টের সাথে লিংক
            $table->string('gateway_name'); // যেমন: 'bkash', 'nagad'
            $table->string('account_number')->nullable();
            $table->decimal('fees_percentage', 5, 2)->default(0); // ফি পার্সেন্টেজ
            $table->boolean('is_enabled')->default(false);
            $table->timestamps();

            // Ensure each user can only have one entry per gateway
            $table->unique(['user_id', 'gateway_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchant_gateways');
    }
};
