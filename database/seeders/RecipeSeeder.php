<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("recipes")->insert(
            [
                [
                    "user_id" => 1,
                    "title" => "Bakwan Jagung",
                    "summary" => "Bakwan jagung khas sidoarjo",
                    "portion" => "2 Orang",
                    "prep_time" => "10 Menit",
                    "is_public" => true,
                    "header_image" => "https://cookpad.com/id/recipe/images/912a3adf059ea559?image_region_id=26",
                ],
                [
                    "user_id" => 1,
                    "title" => "Bakwan Jagung Private",
                    "summary" => "Bakwan jagung khas sidoarjo",
                    "portion" => "2 Orang",
                    "prep_time" => "10 Menit",
                    "is_public" => false,
                    "header_image" => "https://cookpad.com/id/recipe/images/912a3adf059ea559?image_region_id=26",
                ],
                [
                    "user_id" => 2,
                    "title" => "Ote-Ote",
                    "summary" => "Ote-ote khas sidoarjo",
                    "portion" => "2 Orang",
                    "prep_time" => "10 Menit",
                    "is_public" => true,
                    "header_image" => "https://img-global.cpcdn.com/recipes/8c0b4c7edd16f5c5/680x482cq70/bakwan-kol-wortel-foto-resep-utama.webp",
                ],
            ]
        );
    }
}
