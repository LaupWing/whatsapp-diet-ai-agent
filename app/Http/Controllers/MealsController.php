<?php

namespace App\Http\Controllers;

use App\Http\Resources\MealResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

class MealsController extends Controller
{
    /**
     * GET /diet/meals
     */
    public function index(Request $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = $request->attributes->get('user');

        $meals = $user->meals()
            ->with('items')
            ->forDate($request->date)
            ->latest('date')
            ->latest('id')
            ->when($request->filled('limit'), fn($q) => $q->limit($request->limit))
            ->get();

        return response()->json([
            'meals' => MealResource::collection($meals)
        ]);
    }

    /**
     * GET /diet/meals/today
     */
    public function today(Request $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = $request->attributes->get('user');

        $meals = $user->meals()
            ->with('items')
            ->today()
            ->oldest('id')
            ->get();

        return response()->json([
            'date' => today()->toDateString(),
            'meals' => MealResource::collection($meals)
        ]);
    }

    /**
     * GET /diet/macros/today
     * Returns today's totals: calories, protein_grams, carbs_grams, fat_grams.
     */
    public function macrosToday(Request $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = $request->attributes->get('user');
        $date = Carbon::today()->toDateString();

        $row = DB::table('meal_items')
            ->join('meals', 'meal_items.meal_id', '=', 'meals.id')
            ->where('meals.user_id', $user->id)
            ->whereDate('meals.date', $date)
            ->selectRaw('
                COALESCE(SUM(meal_items.calories), 0)        as calories,
                COALESCE(SUM(meal_items.protein_grams), 0)   as protein_grams,
                COALESCE(SUM(meal_items.carbs_grams), 0)     as carbs_grams,
                COALESCE(SUM(meal_items.fat_grams), 0)       as fat_grams,
                COUNT(meal_items.id)                          as items_count
            ')
            ->first();

        $mealsCount = DB::table('meals')
            ->where('user_id', $user->id)
            ->whereDate('date', $date)
            ->count();

        return response()->json([
            'date'   => $date,
            'totals' => [
                'calories'      => (float) $row->calories,
                'protein_grams' => (float) $row->protein_grams,
                'carbs_grams'   => (float) $row->carbs_grams,
                'fat_grams'     => (float) $row->fat_grams,
            ],
            'meals_count' => $mealsCount,
            'items_count' => (int) $row->items_count,
        ]);
    }
}
