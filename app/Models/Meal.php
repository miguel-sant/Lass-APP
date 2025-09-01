<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Meal extends Model{
protected $fillable = ['user_id','food_id','meal_type','amount','calories','protein','carbs','fat','consumed_at'];


public function food(){ return $this->belongsTo(Foods::class); }
}