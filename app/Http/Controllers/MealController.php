<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Meal;
use App\Models\Foods;


class MealController extends Controller
{
       public function store(Request $r)
    {
        $r->validate([
            'food_id' => 'required|exists:foods,id',
            'amount' => 'required|numeric|min:1',
            'meal_type' => 'required|in:Manhã,Tarde,Noite' // Validação para o turno
        ]);

        // Pega o usuário logado ou o primeiro usuário para teste
        $user = auth()->user() ?? \App\Models\User::first();

        $food = Foods::findOrFail($r->food_id);
        
        // Fator de cálculo baseado na porção do alimento
        $factor = $r->amount / ($food->serving_size ?: 100);

        $meal = Meal::create([
            'user_id' => $user->id,
            'food_id' => $food->id,
            'meal_type' => $r->meal_type, // Salva o turno vindo do request
            'amount' => $r->amount,
            'calories' => round($food->calories * $factor, 2),
            'protein' => round($food->protein * $factor, 2),
            'carbs' => round($food->carbs * $factor, 2),
            'fat' => round($food->fat * $factor, 2),
            'consumed_at' => now(),
        ]);

        return response()->json(['success' => true, 'meal' => $meal->load('food')]);
    }


    public function today(Request $r)
    {
        $user = $r->user();
        $meals = Meal::with('food')->where('user_id', $user->id)->whereDate('consumed_at', now())->get();
        return response()->json($meals);
    }
}