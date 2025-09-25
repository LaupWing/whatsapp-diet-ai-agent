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
            'calories' => $this->calories,
            'protein_grams' => $this->protein_grams,
            'carbs_grams' => $this->carbs_grams,
            'fat_grams' => $this->fat_grams,
            'confidence' => $this->confidence,
        ];
    }
}
