<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MealItemResource extends JsonResource
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
            'name' => $this->name,
            'quantity' => $this->quantity,
            'unit' => $this->unit,
            'total_calories' => $this->total_calories,
            'total_protein_grams' => $this->total_protein_grams,
            'total_carbs_grams' => $this->total_carbs_grams,
            'total_fat_grams' => $this->total_fat_grams,
            'total_grams' => $this->total_grams,
            'confidence' => $this->confidence,
        ];
    }
}
