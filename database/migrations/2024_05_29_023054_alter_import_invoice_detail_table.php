<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('import_invoice_details', function (Blueprint $table) {
            $table->unsignedInteger('warehouse_id');
            $table->foreign('warehouse_id')->references('id')->on('warehouse');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
