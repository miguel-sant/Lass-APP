<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NutritionAnalysisController extends Controller
{
    public function analyze(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:4096',
            'goal'  => 'nullable|string'
        ]);

        $pythonUrl = env('AI_SERVICE_URL', 'http://localhost:8001/analyze');

        $resp = Http::timeout(60)->attach(
            'image',
            file_get_contents($request->file('image')->getRealPath()),
            $request->file('image')->getClientOriginalName()
        )->post($pythonUrl, [
            'goal' => $request->input('goal')
        ]);

        if (!$resp->ok()) {
            return response()->json(['success'=>false,'message'=>'Falha serviço IA','status'=>$resp->status()], 502);
        }

        return response()->json([
            'success' => true,
            'data' => $resp->json()
        ]);
    }
}