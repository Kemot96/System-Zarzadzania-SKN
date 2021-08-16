<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('emails')->insert([
            ['type' => "spending_plan_reminder", 'created_at' => now(), 'updated_at' => now(), 'message' => 'Default message'],
            ['type' => "spending_plan_demand_reminder", 'created_at' => now(), 'updated_at' => now(),
                'message' => 'Pamiętaj że realizacja zaplanowanych wydatków musi zostać poprzedzona złożeniem zapotrzebowania. W tym celu skontaktuj się z sekretariatem prorektorów.'],
            ['type' => "action_plan_reminder", 'created_at' => now(), 'updated_at' => now(), 'message' => 'Default message'],
            ['type' => "report_reminder", 'created_at' => now(), 'updated_at' => now(), 'message' => 'Default message'],
            ['type' => "request_to_join_club", 'created_at' => now(), 'updated_at' => now(), 'message' => 'Default message'],
            ['type' => "new_academic_year_acceptance_of_members", 'created_at' => now(), 'updated_at' => now(), 'message' => 'Default message'],
            ['type' => "remove_club_member_request", 'created_at' => now(), 'updated_at' => now(), 'message' => 'Default message'],
            ['type' => "report_submitted", 'created_at' => now(), 'updated_at' => now(), 'message' => 'Default message'],
            ['type' => "report_dismissed", 'created_at' => now(), 'updated_at' => now(), 'message' => 'Default message'],
        ]);
    }
}
