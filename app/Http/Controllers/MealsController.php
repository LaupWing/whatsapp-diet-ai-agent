<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMealRequest;
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
     * POST /diet/food_entries
     */
    public function store(StoreMealRequest $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = $request->attributes->get('user');

        $meal = $user->meals()->create($request->safe()->except('items'));

        $meal->items()->createMany($request->validated('items'));

        return response()->json(
            new MealResource($meal->load('items')),
            201
        );
    }

    /**
     * GET /diet/summary/today
     * Returns today's meals AND macro totals in one response
     */
    public function todaySummary(Request $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = $request->attributes->get('user');

        // Step 1: Get all today's meals with their items (eager loading)
        $meals = $user->meals()
            ->with('items')      // Eager load items to avoid N+1
            ->today()            // Uses your existing scope
            ->oldest('id')       // Order by oldest first
            ->get();

        // Step 2: Flatten all items from all meals into one collection
        $allItems = $meals->flatMap->items;

        // Step 3: Build the response
        return response()->json([
            'date' => today()->toDateString(),
            'meals' => MealResource::collection($meals),
            'totals' => [
                'total_calories' => $allItems->sum('calories'),
                'total_protein_grams' => $allItems->sum('protein_grams'),
                'total_carbs_grams' => $allItems->sum('carbs_grams'),
                'total_fat_grams' => $allItems->sum('fat_grams'),

            ],
            'meals_count' => $meals->count(),
            'items_count' => $allItems->count(),
        ]);
    }
}
