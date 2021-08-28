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
            ['name' => "CREO", 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Instytutu Informatyki Stosowanej", 'created_at' => now(), 'updated_at' => now()],
            ['name' => "SEP", 'created_at' => now(), 'updated_at' => now()],
            ['name' => "IEEE Elblag Student Branch", 'created_at' => now(), 'updated_at' => now()],
            ['name' => "HUMANITAS", 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Młodych Logopedów", 'created_at' => now(), 'updated_at' => now()],
            ['name' => "SENEKA", 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Public Safety", 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Klub Ambasadora", 'created_at' => now(), 'updated_at' => now()],

            ['name' => "FUTURE3D", 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Nowe technologie i informatyczne", 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Akustyk", 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Dziennikarska", 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Językoznawcza", 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Filologów", 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Kulturoznawczo-translatoryczna", 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Pedagogiczno-psychologiczna", 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Graficzno-promocyjna", 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
