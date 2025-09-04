<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('foods', function (Blueprint $table) {
            if (!Schema::hasColumn('foods','portions')) {
                $table->json('portions')->nullable()->after('fat');
            }
            // (Opcional) se quiser explicitar que os macros são por 100g:
            // $table->boolean('values_are_per_100g')->default(true);
        });
    }
    public function down(): void {
        Schema::table('foods', function (Blueprint $table) {
            if (Schema::hasColumn('foods','portions')) {
                $table->dropColumn('portions');
            }
            // $table->dropColumn('values_are_per_100g');
        });
    }
};