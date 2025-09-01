<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
public function up(){
Schema::create('profiles', function(Blueprint $table){
$table->id();
$table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->enum('goal',['gain','lose','maintain'])->default('maintain');
$table->integer('daily_calories_target')->nullable();
$table->integer('daily_protein_target')->nullable();
$table->integer('daily_carbs_target')->nullable();
$table->integer('daily_fat_target')->nullable();
$table->timestamps();
});
}
public function down(){ Schema::dropIfExists('profiles'); }
};