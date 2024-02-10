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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index('idx_user_id');
            $table->string('name')->comment('課程名稱');
            $table->text('introduction')->comment('課程介紹');
            $table->time('start_time')->comment('開始時間');
            $table->time('end_time')->comment('結束時間');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
            $table->unique(['user_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
