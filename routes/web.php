<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\ChallengeController;
use App\Models\Foods;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [DashboardController::class,'index'])->name('dashboard');
Route::get('/food/search', [FoodController::class,'search']); // ajax search
Route::post('/meal', [MealController::class,'store'])->name('meal.store');
Route::get('/meals/today', [MealController::class,'today']);

Route::get('/foods/{food}', function (Foods $food) {
    return response()->json($food);
})->name('foods.show');

Route::resource('friends', FriendController::class)->only(['index','store','update']);
Route::resource('challenges', ChallengeController::class)->only(['index','store','show']);

// API Routes
Route::prefix('api')->group(function () {
    Route::get('/foods/search', [FoodController::class,'search'])->name('api.foods.search');
    Route::get('/foods/{food}', [FoodController::class,'show'])->name('api.foods.show');
});