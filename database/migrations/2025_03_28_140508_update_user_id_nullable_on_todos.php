<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('todos', function (Blueprint $table) {
            // DROP foreign key terlebih dahulu
            $table->dropForeign('todos_user_id_foreign'); // pastikan ini sesuai nama fk-nya

            // Lalu ubah kolom user_id jadi nullable
            $table->unsignedBigInteger('user_id')->nullable()->change();

            // Tambahkan lagi foreign key-nya
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->dropForeign('todos_user_id_foreign');
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
