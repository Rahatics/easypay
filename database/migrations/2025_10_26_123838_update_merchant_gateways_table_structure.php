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
        Schema::table('merchant_gateways', function (Blueprint $table) {
            // Drop the old columns
            $table->dropColumn(['fees', 'enabled']);

            // Add the new columns
            $table->decimal('fees_percentage', 5, 2)->default(0); // ফি পার্সেন্টেজ
            $table->boolean('is_enabled')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('merchant_gateways', function (Blueprint $table) {
            // Drop the new columns
            $table->dropColumn(['fees_percentage', 'is_enabled']);

            // Add back the old columns
            $table->string('fees')->default('1.5% per transaction');
            $table->boolean('enabled')->default(false);
        });
    }
};
