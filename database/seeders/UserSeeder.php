<?php

namespace Database\Seeders;

use DB;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("users")->insert([
            [
                "username" => "jhon123",
                "name" => "Jhon Doe",
                "email" => "test1@mail.com",
                "address" => "Somewhere",
                "role" => "MEMBER",
                "password" => Hash::make("test123456"),
                "image" => "https://upload.wikimedia.org/wikipedia/commons/7/7e/Circle-icons-profile.svg",
            ],
            [
                "username" => "foo123",
                "name" => "Foo Bar",
                "email" => "test2@mail.com",
                "address" => "Somewhere",
                "role" => "MEMBER",
                "password" => Hash::make("test123456"),
                "image" => "https://upload.wikimedia.org/wikipedia/commons/7/7e/Circle-icons-profile.svg",
            ],
            [
                "username" => "admin123",
                "name" => "Admin",
                "email" => "admin@mail.com",
                "address" => "Somewhere",
                "role" => "ADMIN",
                "password" => Hash::make("test123456"),
                "image" => "https://upload.wikimedia.org/wikipedia/commons/7/7e/Circle-icons-profile.svg",
            ],
        ]);
    }
}
