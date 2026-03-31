<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();                                          
            $table->unsignedBigInteger('user_id');                
            $table->unsignedBigInteger('assigned_to')->nullable(); 
            $table->string('judul');
            $table->unsignedBigInteger('kategori_id');
            $table->unsignedBigInteger('prioritas_id');
            $table->text('deskripsi');
            $table->string('lampiran')->nullable(); 
            $table->timestamps();

            // Relasi ke tabel users (pembuat laporan)
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');

            // Relasi ke tabel users (yang ditugaskan)
            $table->foreign('assigned_to')
                ->references('user_id')
                ->on('users')
                ->onDelete('set null');

            $table->foreign('kategori_id')->references('kategori_id')->on('kategoris')->onDelete('cascade');
            $table->foreign('prioritas_id')->references('prioritas_id')->on('priorities')->onDelete('cascade');
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
