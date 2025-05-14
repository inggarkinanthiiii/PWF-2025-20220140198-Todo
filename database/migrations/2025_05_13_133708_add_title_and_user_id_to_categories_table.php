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
        Schema::table('categories', function (Blueprint $table) { // Kurung kurawal dibuka di sini
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('title')->nullable();
        }); // Kurung kurawal ditutup di sini
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) { // Kurung kurawal dibuka di sini
            $table->dropColumn('user_id');
            $table->dropColumn('title');
        }); // Kurung kurawal ditutup di sini
    }
};