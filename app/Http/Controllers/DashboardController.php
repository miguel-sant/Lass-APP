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

        $selectedMonth = $req->input('month', now()->month);
        $selectedYear = $req->input('year', now()->year);

        $today = now();

        $recent = Meal::with('food')
            ->where('user_id', $user->id)
            ->whereDate('consumed_at', $today)
            ->orderBy('consumed_at', 'asc')
            ->get();

        $sums = [
            'calories' => $recent->sum('calories'),
            'protein' => $recent->sum('protein'),
            'carbs' => $recent->sum('carbs'),
            'fat' => $recent->sum('fat'),
        ];
        
        $sumsByPeriod = [
            'Manhã' => ['calories' => $recent->where('meal_type', 'Manhã')->sum('calories')],
            'Tarde' => ['calories' => $recent->where('meal_type', 'Tarde')->sum('calories')],
            'Noite' => ['calories' => $recent->where('meal_type', 'Noite')->sum('calories')],
        ];

        $month = $selectedMonth;
        $year = $selectedYear;
        $daysInMonth = now()->daysInMonth;

        $streaks = \App\Models\UserStreak::where('user_id', auth()->id())
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->pluck('completed', 'date')
            ->toArray();

        $weekDays = [];
        for ($i = -4; $i <= 1; $i++) {
            $date = $today->copy()->addDays($i);
            $weekDays[] = [
                'date' => $date->toDateString(),
                'day' => $date->day,
                'weekday' => $date->format('D'),
                'is_today' => $date->isToday(),
            ];
        }

        $firstDayOfMonth = Carbon::create($selectedYear, $selectedMonth, 1);
        $daysInMonth = $firstDayOfMonth->daysInMonth;
        $monthDays = [];
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $date = Carbon::create($selectedYear, $selectedMonth, $d);
            $monthDays[] = [
                'date' => $date->toDateString(),
                'day' => $d,
                'weekday' => $date->format('D'),
                'is_today' => $date->isToday(),
            ];
        }

        return view('layouts.dashboard', compact('recent', 'sums', 'sumsByPeriod', 'user', 'streaks', 'month', 'year', 'daysInMonth', 'weekDays', 'monthDays', 'selectedMonth', 'selectedYear'));
    }
}