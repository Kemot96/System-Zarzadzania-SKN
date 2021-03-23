<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clubs')->insert([
            ['name' => "CREO", 'created_at' => now(), 'updated_at' => now(), 'icon' => 'icon.jpg'],
            ['name' => "Instytutu Informatyki Stosowanej", 'created_at' => now(), 'updated_at' => now(), 'icon' => 'icon.jpg'],
            ['name' => "SEP", 'created_at' => now(), 'updated_at' => now(), 'icon' => 'icon.jpg'],
            ['name' => "IEEE Elblag Student Branch", 'created_at' => now(), 'updated_at' => now(), 'icon' => 'icon.jpg'],
            ['name' => "HUMANITAS", 'created_at' => now(), 'updated_at' => now(), 'icon' => 'icon.jpg'],
            ['name' => "Młodych Logopedów", 'created_at' => now(), 'updated_at' => now(), 'icon' => 'icon.jpg'],
            ['name' => "SENEKA", 'created_at' => now(), 'updated_at' => now(), 'icon' => 'icon.jpg'],
            ['name' => "Public Safety", 'created_at' => now(), 'updated_at' => now(), 'icon' => 'icon.jpg'],
            ['name' => "Klub Ambasadora", 'created_at' => now(), 'updated_at' => now(), 'icon' => 'icon.jpg'],
        ]);
    }
}
