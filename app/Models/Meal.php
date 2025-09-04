<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Meal extends Model{
protected $fillable = [
  'user_id','food_id','meal_type','amount',
  'calories','protein','carbs','fat',
  'portion_name','portion_grams','quantity','total_grams','consumed_at'
];

public function food(){ return $this->belongsTo(Foods::class); }
}