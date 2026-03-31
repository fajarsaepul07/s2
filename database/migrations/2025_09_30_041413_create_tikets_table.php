<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tikets', function (Blueprint $table) {
            $table->id('tiket_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->unsignedBigInteger('kategori_id');

            // 🆕 Tambahan kolom baru
            $table->string('kode_tiket')->unique();
            $table->string('judul');

            $table->text('deskripsi')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('prioritas_id');
            $table->dateTime('waktu_dibuat')->useCurrent();
            $table->dateTime('waktu_selesai')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('assigned_to')->references('user_id')->on('users')->onDelete('set null');
            $table->foreign('kategori_id')->references('kategori_id')->on('kategoris')->onDelete('cascade');
            $table->foreign('status_id')->references('status_id')->on('tiket_statuses')->onDelete('cascade');
            $table->foreign('prioritas_id')->references('prioritas_id')->on('priorities')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tikets');
    }
};
