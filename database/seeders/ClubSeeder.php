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
            ['name' => "CREO", 'created_at' => now(), 'updated_at' => now(), 'is_section' => FALSE],
            ['name' => "Instytutu Informatyki Stosowanej", 'created_at' => now(), 'updated_at' => now(), 'is_section' => FALSE],
            ['name' => "SEP", 'created_at' => now(), 'updated_at' => now(), 'is_section' => FALSE],
            ['name' => "IEEE Elblag Student Branch", 'created_at' => now(), 'updated_at' => now(), 'is_section' => FALSE],
            ['name' => "HUMANITAS", 'created_at' => now(), 'updated_at' => now(), 'is_section' => FALSE],
            ['name' => "Młodych Logopedów", 'created_at' => now(), 'updated_at' => now(), 'is_section' => FALSE],
            ['name' => "SENEKA", 'created_at' => now(), 'updated_at' => now(), 'is_section' => FALSE],
            ['name' => "Public Safety", 'created_at' => now(), 'updated_at' => now(), 'is_section' => FALSE],
            ['name' => "Klub Ambasadora", 'created_at' => now(), 'updated_at' => now(), 'is_section' => FALSE],

            ['name' => "FUTURE3D", 'created_at' => now(), 'updated_at' => now(), 'is_section' => TRUE],
            ['name' => "Nowe technologie i informatyczne", 'created_at' => now(), 'updated_at' => now(), 'is_section' => TRUE],
            ['name' => "Akustyk", 'created_at' => now(), 'updated_at' => now(), 'is_section' => TRUE],
            ['name' => "Dziennikarska", 'created_at' => now(), 'updated_at' => now(), 'is_section' => TRUE],
            ['name' => "Językoznawcza", 'created_at' => now(), 'updated_at' => now(), 'is_section' => TRUE],
            ['name' => "Filologów", 'created_at' => now(), 'updated_at' => now(), 'is_section' => TRUE],
            ['name' => "Kulturoznawczo-translatoryczna", 'created_at' => now(), 'updated_at' => now(), 'is_section' => TRUE],
            ['name' => "Pedagogiczno-psychologiczna", 'created_at' => now(), 'updated_at' => now(), 'is_section' => TRUE],
            ['name' => "Graficzno-promocyjna", 'created_at' => now(), 'updated_at' => now(), 'is_section' => TRUE],
        ]);
    }
}
