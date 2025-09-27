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
                'label' => 'breakfast',
                'items' => [
                    [
                        'name' => 'Oatmeal',
                        'quantity' => 80,
                        'unit' => 'g',
                        'calories' => 300,
                        'protein_grams' => 10,
                        'carbs_grams' => 52,
                        'fat_grams' => 5
                    ],
                    [
                        'name' => 'Banana',
                        'quantity' => 1,
                        'unit' => 'medium',
                        'calories' => 105,
                        'protein_grams' => 1.3,
                        'carbs_grams' => 27,
                        'fat_grams' => 0.3
                    ],
                ],
            ],
            [
                'created_at'  => $today,
                'label' => 'lunch',
                'items' => [
                    [
                        'name' => 'Chicken salad',
                        'quantity' => 1,
                        'unit' => 'bowl',
                        'calories' => 420,
                        'protein_grams' => 35,
                        'carbs_grams' => 18,
                        'fat_grams' => 24
                    ],
                ],
            ],
            [
                'created_at'  => $today,
                'label' => 'dinner',
                'items' => [
                    [
                        'name' => 'Salmon fillet',
                        'quantity' => 180,
                        'unit' => 'g',
                        'calories' => 367,
                        'protein_grams' => 39,
                        'carbs_grams' => 0,
                        'fat_grams' => 22
                    ],
                    [
                        'name' => 'White rice (cooked)',
                        'quantity' => 200,
                        'unit' => 'g',
                        'calories' => 260,
                        'protein_grams' => 5,
                        'carbs_grams' => 57,
                        'fat_grams' => 0.4
                    ],
                    [
                        'name' => 'Broccoli',
                        'quantity' => 100,
                        'unit' => 'g',
                        'calories' => 35,
                        'protein_grams' => 2.4,
                        'carbs_grams' => 7,
                        'fat_grams' => 0.4
                    ],
                ],
            ],
            [
                'created_at'  => $yesterday,
                'label' => 'breakfast',
                'items' => [
                    [
                        'name' => 'Greek yogurt',
                        'quantity' => 200,
                        'unit' => 'g',
                        'calories' => 146,
                        'protein_grams' => 20,
                        'carbs_grams' => 7.8,
                        'fat_grams' => 3.8
                    ],
                    [
                        'name' => 'Honey',
                        'quantity' => 15,
                        'unit' => 'g',
                        'calories' => 46,
                        'protein_grams' => 0,
                        'carbs_grams' => 12.4,
                        'fat_grams' => 0
                    ],

                ],
            ],
        ];

        foreach ($meals as $m) {
            $meal = Meal::create([
                'user_id' => $user->id,
                'created_at'    => $m['created_at']->toDateString(),
                'label'   => $m['label'],
                'source'  => 'manual',
                'notes'   => null,
            ]);

            foreach ($m['items'] as $it) {
                MealItem::create([
                    'meal_id'   => $meal->id,
                    'name'      => $it['name'],
                    'quantity'  => $it['quantity'],
                    'unit'      => $it['unit'],
                    'calories'  => $it['calories'],
                    'protein_grams' => $it['protein_grams'],
                    'carbs_grams'   => $it['carbs_grams'],
                    'fat_grams'     => $it['fat_grams'],
                    'confidence'    => 1.0,
                ]);
            }
        }
    }
}
