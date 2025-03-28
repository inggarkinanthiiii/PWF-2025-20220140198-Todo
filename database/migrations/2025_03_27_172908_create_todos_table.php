<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Kolom user_id bisa null
            $table->string('title'); // Kolom title
            $table->boolean('is_done')->default(false); // Status selesai atau tidak
            $table->timestamps(); // Kolom created_at dan updated_at

              // Jika ingin menghubungkan ke tabel users, tambahkan foreign key
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Undo migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
