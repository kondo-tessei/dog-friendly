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
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('registrant_id');
            $table->string('name', 128);
            $table->text('email')->nullable();
            $table->string('tel', 12);
            $table->string('address', 255);
            $table->double('latitude');
            $table->double('longitude');
            $table->text('description')->nullable();
            $table->string('category', 50);
            $table->string('website', 255)->nullable();
            $table->binary('photos')->nullable();
            $table->string('prefecture', 128)->nullable();
            $table->string('okPetSize', 12)->nullable();
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->default('1000-01-01 00:00:00');

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
