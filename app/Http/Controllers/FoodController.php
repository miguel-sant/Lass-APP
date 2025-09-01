<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Foods;


class FoodController extends Controller
{
    public function search(Request $r)
    {
        $q = $r->input('q');
        $foods = Foods::where('name', 'like', '%' . $q . '%')->limit(20)->get();

        return response()->json($foods);
    }
}