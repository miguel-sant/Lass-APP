<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('daily_calorie_target')->default(2000);
            $table->integer('daily_protein_target')->default(150);
            $table->integer('daily_carbs_target')->default(200);
            $table->integer('daily_fat_target')->default(60);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'daily_calorie_target',
                'daily_protein_target',
                'daily_carbs_target',
                'daily_fat_target'
            ]);
        });
    }
};