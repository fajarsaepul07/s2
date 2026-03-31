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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('notif_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('tiket_id');
            $table->text('pesan');
            $table->dateTime('waktu_kirim')->useCurrent();
            $table->boolean('status_baca')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('tiket_id')->references('tiket_id')->on('tikets')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
