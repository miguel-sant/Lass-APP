<?php
namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\Meal;
use App\Models\Foods;


class MealController extends Controller
{
       public function store(Request $r)
    {
        $user = Auth::user();
        dd($r);
        $data = $r->validate([
            'food_name'=>'required|exists:foods,name',
            'meal_type'=>'required|string',
            'portion_name'=>'nullable|string',
            'portion_grams'=>'nullable|numeric',
            'quantity'=>'nullable|numeric|min:0.01',
            'total_grams'=>'nullable|numeric|min:0.01'
        ]);

        $food = Foods::where('name', $data['food_name'])->firstOrFail();
        $grams = $data['total_grams'] ?? ($food->serving_size ?: 100);

        // Assumindo macros por 100g
        $cal = ($food->calories * $grams)/100;
        $prot = ($food->protein * $grams)/100;
        $carb = ($food->carbs * $grams)/100;
        $fat = ($food->fat * $grams)/100;

        $meal = Meal::create([
            'user_id' => $user->id,
            'meal_type' => $request->meal_type ?? 'Manhã',
            'calories' => $request->calories ?? 0,
            'protein' => $request->protein ?? 0,
            'carbs' => $request->carbs ?? 0,
            'fat' => $request->fat ?? 0,
            'consumed_at' => $request->consumed_at ?? now(),
        ]);

        return response()->json(['success'=>true,  'meal' => $meal]);
    }


    public function today(Request $r)
    {
        $user = $r->user();
        $meals = Meal::with('food')->where('user_id', $user->id)->whereDate('consumed_at', now())->get();
        return response()->json($meals);
    }
}