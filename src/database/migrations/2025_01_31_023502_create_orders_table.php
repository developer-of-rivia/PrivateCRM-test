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
            $table->timestamps();

            $table->string('client_name');
            $table->string('client_phone', 11)->unique();
            $table->enum('schedule_type', ['EVERY_DAY', 'EVERY_OTHER_DAY', 'EVERY_OTHER_DAY_TWICE']);
            $table->string('comment')->nullable();
            $table->date('first_date');
            $table->date('last_date');

            $table->unsignedBigInteger('tariff_id');
            $table->index('tariff_id', 'tariff_order_tariff_idx');
            $table->foreign('tariff_id', 'tariff_order_tariff_fk')->on('tariffs')->references('id')->onDelete('cascade');
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
