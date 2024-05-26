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
        Schema::create('import_invoice_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quantity');
            $table->integer('variant_id');
            $table->foreign('variant_id')->references('VARRIANTID')->on('ProductVariant');
            $table->string('import_invoice_id');
            $table->foreign('import_invoice_id')->references('id')->on('import_invoice');
            $table->integer('price');
            $table->integer('discount')->default(0);
            $table->boolean('status')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_invoice_details');
    }
};
