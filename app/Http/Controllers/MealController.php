<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Meal;
use App\Models\Foods;


class MealController extends Controller
{
       public function store(Request $r)
    {
        $data = $r->validate([
            'food_id'=>'required|exists:foods,id',
            'meal_type'=>'required|string',
            'portion_name'=>'nullable|string',
            'portion_grams'=>'nullable|numeric',
            'quantity'=>'nullable|numeric|min:0.01',
            'total_grams'=>'nullable|numeric|min:0.01'
        ]);

        $food = Foods::findOrFail($data['food_id']);
        $grams = $data['total_grams'] ?? ($food->serving_size ?: 100);

        // Assumindo macros por 100g
        $cal = ($food->calories * $grams)/100;
        $prot = ($food->protein * $grams)/100;
        $carb = ($food->carbs * $grams)/100;
        $fat = ($food->fat * $grams)/100;

        Meal::create([
            'user_id'=>auth()->id(),
            'food_id'=>$food->id,
            'meal_type'=>$data['meal_type'],
            'amount'=>$grams, // se amount já representa gramas
            'calories'=>$cal,
            'protein'=>$prot,
            'carbs'=>$carb,
            'fat'=>$fat,
            'portion_name'=>$data['portion_name'] ?? null,
            'portion_grams'=>$data['portion_grams'] ?? null,
            'quantity'=>$data['quantity'] ?? 1,
            'total_grams'=>$grams,
            'consumed_at'=>now(),
        ]);

        return response()->json(['success'=>true]);
    }


    public function today(Request $r)
    {
        $user = $r->user();
        $meals = Meal::with('food')->where('user_id', $user->id)->whereDate('consumed_at', now())->get();
        return response()->json($meals);
    }
}