<?php

namespace App\Http\Controllers;

use App\Http\Resources\MealResource;
use Illuminate\Http\Request;
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
}
