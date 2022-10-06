<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                "_id" => "976ffc0fe0794c8eb48cf447fa4f9558",
                "username" => "majdsh",
                "password" => bcrypt("vip12345"),
                "phone_number" => "0937423525",
                "email" => "majdsha@gmail.com"
            ],[
                "_id" => "976ffc0ff84d4896ad9a9a4c103bdd13",
                "username" => "mhd",
                "password" => bcrypt("vip12345"),
                "phone_number" => "0937423526",
                "email" => "mhda@gmail.com"
            ],[
                "_id" => "976ffc100df74d9085379dd29a949929",
                "username" => "abd",
                "password" => bcrypt("vip12345"),
                "phone_number" => "0937423527",
                "email" => "abda@gmail.com"
            ]
        ]);
    }
}
