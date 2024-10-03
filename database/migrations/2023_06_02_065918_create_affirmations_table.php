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
        Schema::create('affirmations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->references('id')->on('categories')->onDelete('cascade');
            $table->foreignId('binaural_beat_id')->nullable()->references('id')->on('binaural_beats')->onDelete('cascade');
            $table->foreignId('background_audio_id')->nullable()->references('id')->on('background_audio')->onDelete('cascade');
            $table->string('name');
            $table->string('recorded_audio');
            $table->string('mix_audio')->nullable();
            $table->string('recorded_transcription');
            $table->text('images')->nullable();
            $table->string('effect_type')->nullable();
            $table->enum('is_transcription_display', [0, 1])->default(0);
            $table->integer('step')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affirmations');
    }
};
