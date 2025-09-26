<?php

namespace Database\Seeders;

use App\Enums\WeightUnit;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['whatsapp_id' => '+31123456789'],
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => Hash::make('password'),
                'whatsapp_phone' => '31123456789',
                'unit_weight' => WeightUnit::KG,
                'unit_for_exercises' => WeightUnit::KG,
            ]
        );

        $this->call([
            SampleDataSeeder::class,
        ]);
    }
}
