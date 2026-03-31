<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('priorities', function (Blueprint $table) {
            $table->id('prioritas_id');
            $table->string('nama_prioritas')->unique(); // ✅ Tambahkan unique
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('priorities');
    }
};