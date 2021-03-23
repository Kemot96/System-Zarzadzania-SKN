<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $club_iis = DB::table('clubs') -> select('id') -> where('name', 'Instytutu Informatyki Stosowanej') -> first();
        $club_HUMANITAS = DB::table('clubs') -> select('id') -> where('name', 'HUMANITAS') -> first();
        DB::table('sections')->insert([
            ['clubs_id' => $club_iis -> id, 'name' => 'FUTURE3D', 'created_at' => now(), 'updated_at' => now()],
            ['clubs_id' => $club_iis -> id, 'name' => 'Nowe technologie i informatyczne', 'created_at' => now(), 'updated_at' => now()],
            ['clubs_id' => $club_iis -> id, 'name' => 'Akustyk', 'created_at' => now(), 'updated_at' => now()],
            ['clubs_id' => $club_HUMANITAS -> id, 'name' => 'Dziennikarska', 'created_at' => now(), 'updated_at' => now()],
            ['clubs_id' => $club_HUMANITAS -> id, 'name' => 'Językoznawcza', 'created_at' => now(), 'updated_at' => now()],
            ['clubs_id' => $club_HUMANITAS -> id, 'name' => 'Filologów', 'created_at' => now(), 'updated_at' => now()],
            ['clubs_id' => $club_HUMANITAS -> id, 'name' => 'Kulturoznawczo-translatoryczna', 'created_at' => now(), 'updated_at' => now()],
            ['clubs_id' => $club_HUMANITAS -> id, 'name' => 'Pedagogiczno-psychologiczna', 'created_at' => now(), 'updated_at' => now()],
            ['clubs_id' => $club_HUMANITAS -> id, 'name' => 'Graficzno-promocyjna', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
