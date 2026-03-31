<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Ubah kolom role menjadi string biasa (lebih fleksibel)
            $table->string('role', 50)->default('customer')->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kembalikan ke enum lama jika ingin rollback
            $table->enum('role', ['admin', 'customer'])->default('customer')->change();
        });
    }
};
