<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
    public function up()
    {
        Schema::create('friends', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('friend_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('status')->default('pending'); // pending, accepted
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('friends');
    }
};