<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id(); // Kolom id utama
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key user_id yang terhubung ke tabel users
            $table->string('title'); // Kolom judul todo
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->boolean('status')->default(0); // Kolom status, default 0 (belum selesai)
            $table->timestamps(); // Kolom timestamps (created_at, updated_at)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('todos'); // Hapus tabel todos saat migrasi dibatalkan
    }
}
