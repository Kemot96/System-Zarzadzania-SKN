<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //TODO Nie pozwalaj na wszystkie kombinacje id-ków, teraz user nie będący w danym klubie może być w należącej do niego sekcji (średni priorytet)
        for ($i = 1; $i <= 20; $i++) {
            $random_users_id = DB::table('users') -> inRandomOrder() -> value('id');
            $random_sections_id = DB::table('sections') -> inRandomOrder() -> value('id');
            $random_academic_years_id = DB::table('academic_years') -> inRandomOrder() -> value('id');


            DB::table('members_sections')->insert([
                ['users_id' => $random_users_id, 'sections_id' => $random_sections_id, 'academic_years_id' => $random_academic_years_id, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
    }
}
