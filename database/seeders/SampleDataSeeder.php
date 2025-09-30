<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Meal;
use App\Models\MealItem;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('whatsapp_id', '+31123456789')->first();
        if (!$user) {
            $this->command?->warn('Run TestUserSeeder first.');
            return;
        }
        $today      = Carbon::today();
        $yesterday  = Carbon::today()->subDay();

        /**
         * 1) Meals (array of meals, each with items)
         */
        $meals = [
            [
                'created_at'  => $today,
                'meal_type' => 'breakfast',
                'items' => [
                    [
                        'name' => 'Oatmeal',
                        'quantity' => 80,
                        'unit' => 'g',
                        'total_calories' => 300,
                        'total_protein_grams' => 10,
                        'total_carbs_grams' => 52,
                        'estimated_weight_grams' => 80,
                        'total_fat_grams' => 5
                    ],
                    [
                        'name' => 'Banana',
                        'quantity' => 1,
                        'unit' => 'medium',
                        'total_calories' => 105,
                        'total_protein_grams' => 1.3,
                        'total_carbs_grams' => 27,
                        'total_fat_grams' => 0.3,
                        'estimated_weight_grams' => 118,
                    ],
                ],
            ],
            [
                'created_at'  => $today,
                'meal_type' => 'lunch',
                'items' => [
                    [
                        'name' => 'Chicken salad',
                        'quantity' => 1,
                        'unit' => 'bowl',
                        'total_calories' => 420,
                        'total_protein_grams' => 35,
                        'total_carbs_grams' => 18,
                        'total_fat_grams' => 24,
                        'estimated_weight_grams' => 300,
                    ],
                ],
            ],
            [
                'created_at'  => $today,
                'meal_type' => 'dinner',
                'items' => [
                    [
                        'name' => 'Salmon fillet',
                        'quantity' => 180,
                        'unit' => 'g',
                        'total_calories' => 367,
                        'total_protein_grams' => 39,
                        'total_carbs_grams' => 0,
                        'total_fat_grams' => 22,
                        'estimated_weight_grams' => 180,
                    ],
                    [
                        'name' => 'White rice (cooked)',
                        'quantity' => 200,
                        'unit' => 'g',
                        'total_calories' => 260,
                        'total_protein_grams' => 5,
                        'total_carbs_grams' => 57,
                        'total_fat_grams' => 0.4,
                        'estimated_weight_grams' => 200,
                    ],
                    [
                        'name' => 'Broccoli',
                        'quantity' => 100,
                        'unit' => 'g',
                        'total_calories' => 35,
                        'total_protein_grams' => 2.4,
                        'total_carbs_grams' => 7,
                        'total_fat_grams' => 0.4,
                        'estimated_weight_grams' => 100,
                    ],
                ],
            ],
            [
                'created_at'  => $yesterday,
                'meal_type' => 'breakfast',
                'items' => [
                    [
                        'name' => 'Greek yogurt',
                        'quantity' => 200,
                        'unit' => 'g',
                        'total_calories' => 146,
                        'total_protein_grams' => 20,
                        'total_carbs_grams' => 7.8,
                        'total_fat_grams' => 3.8,
                        'estimated_weight_grams' => 200,
                    ],
                    [
                        'name' => 'Honey',
                        'quantity' => 15,
                        'unit' => 'g',
                        'total_calories' => 46,
                        'total_protein_grams' => 0,
                        'total_carbs_grams' => 12.4,
                        'total_fat_grams' => 0,
                        'estimated_weight_grams' => 15,
                    ],

                ],
            ],
        ];

        foreach ($meals as $m) {
            $meal = Meal::create([
                'user_id' => $user->id,
                'created_at'    => $m['created_at']->toDateString(),
                'meal_type'   => $m['meal_type'],
                'source'  => 'manual',
                'notes'   => null,
            ]);

            foreach ($m['items'] as $it) {
                MealItem::create([
                    'meal_id'   => $meal->id,
                    'name'      => $it['name'],
                    'quantity'  => $it['quantity'],
                    'unit'      => $it['unit'],
                    'total_calories'  => $it['total_calories'],
                    'total_protein_grams' => $it['total_protein_grams'],
                    'total_carbs_grams'   => $it['total_carbs_grams'],
                    'total_fat_grams'     => $it['total_fat_grams'],
                    'estimated_weight_grams'         => $it['estimated_weight_grams'],
                    'confidence'    => 1.0,
                ]);
            }
        }
    }
}
