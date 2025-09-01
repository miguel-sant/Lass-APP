<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meal;
use Carbon\Carbon;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $req)
    {
        // Pega o usuário logado ou cria um de exemplo
        $user = auth()->user() ?? User::firstOrCreate(
            ['email' => 'mocado@example.com'],
            [
                'name' => 'Usuário Moc',
                'password' => bcrypt('123456'),
                'daily_calorie_target' => 2500,
                'daily_protein_target' => 150,
                'daily_carbs_target' => 300,
                'daily_fat_target' => 70,
            ]
        );

        $today = now()->toDateString();

        // Pega todas as refeições de hoje
        $recent = Meal::with('food')
            ->where('user_id', $user->id)
            ->whereDate('consumed_at', $today)
            ->orderBy('consumed_at', 'asc') // Ordena por hora para a lista
            ->get();

        // Calcula a soma total do dia
        $sums = [
            'calories' => $recent->sum('calories'),
            'protein' => $recent->sum('protein'),
            'carbs' => $recent->sum('carbs'),
            'fat' => $recent->sum('fat'),
        ];
        
        // Calcula as somas por período
        $sumsByPeriod = [
            'Manhã' => ['calories' => $recent->where('meal_type', 'Manhã')->sum('calories')],
            'Tarde' => ['calories' => $recent->where('meal_type', 'Tarde')->sum('calories')],
            'Noite' => ['calories' => $recent->where('meal_type', 'Noite')->sum('calories')],
        ];

        return view('layouts.dashboard', compact('recent', 'sums', 'sumsByPeriod', 'user'));
    }
}