<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->after('id');
            $table->string('title')->after('user_id');
            $table->boolean('is_done')->default(false)->after('title');
        });
    }
    
    public function down()
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'title', 'is_done']);
        });
    }
    

};
