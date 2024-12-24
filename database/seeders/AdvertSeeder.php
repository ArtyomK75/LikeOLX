<?php

namespace Database\Seeders;

use App\Models\Advert;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdvertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adverts = [];
        $usersIds = User::get()->pluck('id');
        $categoriesIds = Category::get()->pluck('id');
        for ($i = 0; $i < 80; $i++) {
            $adverts[] = [
                'title' => Str::random(20),
                'description' => Str::random(100),
                'price' => rand(10, 1000),
                'category_id' => $categoriesIds->random(),
                'user_id' => $usersIds->random(),
                'created_at' => now(),
                'updated_at' => now(),
                'is_active' => rand(0, 1),
            ];
        }
        Advert::insert($adverts);

    }
}
