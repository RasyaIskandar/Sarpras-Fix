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
        Schema::table('laporans', function (Blueprint $table) {
            $table->text('deskripsi_tindakan')->nullable(); // deskripsi admin
            $table->string('bukti')->nullable(); // foto/video bukti selesai
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn(['deskripsi_tindakan', 'bukti']);
        });
    }
};
