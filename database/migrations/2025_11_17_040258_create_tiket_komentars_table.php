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
        Schema::create('tiket_komentars', function (Blueprint $table) {
            $table->id('komentar_id');
            $table->unsignedBigInteger('tiket_id');
            $table->unsignedBigInteger('user_id');
            $table->text('komentar');
            $table->tinyInteger('rating')->nullable()->comment('1-5 stars');
            $table->enum('tipe_komentar', ['feedback', 'evaluasi', 'complaint'])->default('feedback');
            $table->timestamp('waktu_komentar')->useCurrent();
            $table->timestamps();

            // Foreign keys
            $table->foreign('tiket_id')
                ->references('tiket_id')
                ->on('tikets')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiket_komentars');
    }
};
