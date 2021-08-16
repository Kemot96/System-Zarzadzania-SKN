<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClubMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //TODO nie pozwalaj na wszystkie kombinacje id-ków
        for ($i = 1; $i <= 20; $i++) {
            $random_users_id = DB::table('users') -> inRandomOrder() -> value('id');
            $random_roles_id = DB::table('roles') -> where('special_role', FALSE) -> inRandomOrder() -> value('id');
            $random_clubs_id = DB::table('clubs') -> inRandomOrder() -> value('id');
            $random_academic_years_id = DB::table('academic_years') -> inRandomOrder() -> value('id');


            DB::table('club_members')->insert([
                ['users_id' => $random_users_id, 'roles_id' => $random_roles_id, 'clubs_id' => $random_clubs_id, 'academic_years_id' => $random_academic_years_id, 'removal_request' => FALSE, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
    }
}
