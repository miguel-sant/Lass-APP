<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('meals', function (Blueprint $table) {
            if (!Schema::hasColumn('meals','portion_name')) {
                $table->string('portion_name')->nullable()->after('meal_type');
                $table->decimal('portion_grams',8,2)->nullable()->after('portion_name');
                $table->decimal('quantity',8,2)->default(1)->after('portion_grams');
                $table->decimal('total_grams',8,2)->nullable()->after('quantity');
            }
        });
    }
    public function down(): void {
        Schema::table('meals', function (Blueprint $table) {
            $table->dropColumn(['portion_name','portion_grams','quantity','total_grams']);
        });
    }
};