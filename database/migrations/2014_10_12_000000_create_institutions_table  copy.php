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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id('review_id');
            $table->unsignedBigInteger('user_id');
            $table->string('nickname', 16);
            $table->integer('evaluation');
            $table->string('comment', 1024);
            $table->binary('photos')->nullable();
            $table->string('pet_size', 8);
            $table->unsignedBigInteger('institution_id');
            $table->dateTime('created')->nullable();
            $table->dateTime('updated')->default('1000-01-01 00:00:00');
            $table->integer('del_flg')->default(0);
            $table->timestamps(); // created_at と updated_at カラムを追加
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
