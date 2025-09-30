<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'meal_type' => $this->meal_type,
            'source' => $this->source,
            'notes' => $this->notes,
            'items' => MealItemResource::collection($this->whenLoaded('items')),
            'totals' => [
                'calories' => $this->items->sum('total_calories'),
                'protein_grams' => $this->items->sum('total_protein_grams'),
                'carbs_grams' => $this->items->sum('total_carbs_grams'),
                'fat_grams' => $this->items->sum('total_fat_grams'),
            ],
        ];
    }
}
