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
        Schema::create('order_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->foreign('order_id')->references('OrderID')->on('Orders');
            $table->integer('variant_id');
            $table->foreign('variant_id')->references('VARRIANTID')->on('ProductVariant');
            $table->integer('quantity');
            $table->integer('price');
            $table->integer('total')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_detail');
    }
};
