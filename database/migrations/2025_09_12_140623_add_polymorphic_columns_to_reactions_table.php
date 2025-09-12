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
        Schema::table('reactions', function (Blueprint $table) {
            // This will create 'reactable_id' and 'reactable_type' columns
            $table->morphs('reactable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reactions', function (Blueprint $table) {
            // This will drop both columns
            $table->dropMorphs('reactable');
        });
    }
};