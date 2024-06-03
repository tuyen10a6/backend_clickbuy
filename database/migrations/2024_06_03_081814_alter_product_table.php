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
        Schema::table('Product', function (Blueprint $table) {
              $table->string('he_dieu_hanh')->nullable();
              $table->string('bo_nho_trong')->nullable();
              $table->string('ram')->nullable();
              $table->string('camera_chinh')->nullable();
              $table->string('man_hinh')->nullable();
              $table->string('kich_thuoc')->nullable();
              $table->string('trong_luong')->nullable();
              $table->string('do_phan_giai')->nullable();
              $table->string('camera_phu')->nullable();
              $table->string('mau_sac')->nullable();
              $table->string('dung_luong_pin')->nullable();
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
