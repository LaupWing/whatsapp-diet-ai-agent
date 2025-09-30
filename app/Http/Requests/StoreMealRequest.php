<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMealRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        logger()->info('Validating StoreMealRequest', $this->all());
        return [
            'label' => ['required', 'string', 'max:255'],
            'source' => ['nullable', 'string', 'in:manual,api,import'],
            'notes' => ['nullable', 'string', 'max:1000'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.name' => ['required', 'string', 'max:255'],
            'items.*.quantity' => ['required', 'numeric', 'min:0'],
            'items.*.unit' => ['required', 'string', 'max:50'],
            'items.*.total_calories' => ['required', 'numeric', 'min:0'],
            'items.*.total_protein_grams' => ['required', 'numeric', 'min:0'],
            'items.*.total_carbs_grams' => ['required', 'numeric', 'min:0'],
            'items.*.total_fat_grams' => ['required', 'numeric', 'min:0'],
            'items.*.estimated_weight_grams' => ['required', 'numeric', 'min:0'],
            'items.*.confidence' => ['nullable', 'numeric', 'min:0', 'max:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'label.required' => 'Meal label is required.',
            'items.required' => 'Items array is required.',
            'items.min' => 'At least one item is required.',
            'items.*.name.required' => 'Item name is required.',
            'items.*.quantity.required' => 'Item quantity is required.',
            'items.*.unit.required' => 'Item unit is required.',
            'items.*.total_calories.required' => 'Item calories is required.',
            'items.*.total_protein_grams.required' => 'Item protein_grams is required.',
            'items.*.total_carbs_grams.required' => 'Item carbs_grams is required.',
            'items.*.total_fat_grams.required' => 'Item fat_grams is required.',
            'items.*.estimated_weight_grams' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
