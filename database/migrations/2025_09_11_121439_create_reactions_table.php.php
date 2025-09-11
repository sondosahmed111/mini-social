<?php

// 1. Database Migration - create_reactions_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->morphs('reactable'); // For polymorphic relationship (posts, comments, etc.)
            $table->enum('type', ['like', 'love', 'laugh', 'angry', 'sad']);
            $table->timestamps();
            
            // Prevent duplicate reactions from same user on same item
            $table->unique(['user_id', 'reactable_id', 'reactable_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('reactions');
    }
};