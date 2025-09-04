<?php
namespace App\Http\Controllers;

use App\Models\Foods;
use Illuminate\Http\Request;
use App\Models\Food;

class FoodController extends Controller
{
    public function search(Request $r)
    {
        $q = trim($r->input('q',''));
        if($q==='') return response()->json([]);
        $foods = Foods::where('name','like',"%{$q}%")
            ->orderBy('name')
            ->limit(20)
            ->get();
        return response()->json($foods);
    }

    public function show(Foods $food)
    {
        return response()->json($food);
    }
}