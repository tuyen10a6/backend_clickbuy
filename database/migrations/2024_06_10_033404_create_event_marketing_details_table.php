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
        Schema::create('event_marketing_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('nguoi_phu_trach')->nullable();
            $table->string('address_event');
            $table->dateTime('date_start')->nullable();
            $table->dateTime('date_end')->nullable();
            $table->string('status')->default('0');
            $table->string('event_marketing_id');
            $table->foreign('event_marketing_id')
                ->references('id')
                ->on('event_marketing');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_marketing_details');
    }
};
