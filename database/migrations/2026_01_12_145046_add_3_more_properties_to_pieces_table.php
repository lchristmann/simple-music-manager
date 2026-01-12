<?php

use App\Enums\DifficultyLevel;
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
        Schema::table('pieces', function (Blueprint $table) {
            $table->string('arranged_by')->nullable();
            $table->string('sheet_music_link')->nullable();
            $table->string('difficulty')->default(DifficultyLevel::MEDIUM->value);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pieces', function (Blueprint $table) {
            $table->dropColumn('arranged_by');
            $table->dropColumn('sheet_music_link');
            $table->dropColumn('difficulty');
        });
    }
};
