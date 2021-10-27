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
            ['type' => "spending_plan_reminder", 'day' => '15', 'month' => '11', 'enable_sending' => '1', 'send_on_schedule' => '1',
                'day2' => NULL, 'month2' => NULL, 'send_on_schedule2' => '0', 'created_at' => now(), 'updated_at' => now(), 'message' => 'Default message'],
            ['type' => "spending_plan_demand_reminder", 'day' => '30', 'month' => '4', 'send_on_schedule' => '1',
                'day2' => '30', 'month2' => '10', 'send_on_schedule2' => '1', 'enable_sending' => '1', 'created_at' => now(), 'updated_at' => now(),
                'message' => 'Pamiętaj że realizacja zaplanowanych wydatków musi zostać poprzedzona złożeniem zapotrzebowania. W tym celu skontaktuj się z sekretariatem prorektorów.'],
            ['type' => "action_plan_reminder", 'day' => '30', 'month' => '10', 'enable_sending' => '1', 'send_on_schedule' => '1',
                'day2' => NULL, 'month2' => NULL, 'send_on_schedule2' => '0', 'created_at' => now(), 'updated_at' => now(), 'message' => 'Default message'],
            ['type' => "report_reminder", 'day' => '15', 'month' => '6', 'enable_sending' => '1', 'send_on_schedule' => '1', 'day2' => NULL, 'month2' => NULL,
                'send_on_schedule2' => '0', 'created_at' => now(), 'updated_at' => now(), 'message' => 'Default message'],
            ['type' => "new_academic_year_acceptance_of_members",  'day' => '30', 'month' => '10', 'enable_sending' => '1', 'send_on_schedule' => '1',
                'day2' => NULL, 'month2' => NULL, 'send_on_schedule2' => '0', 'created_at' => now(), 'updated_at' => now(), 'message' => 'Default message'],
            ['type' => "request_to_join_club", 'day' => NULL, 'month' => NULL, 'enable_sending' => '1', 'send_on_schedule' => '0', 'day2' => NULL, 'month2' => NULL,
                'send_on_schedule2' => '0', 'created_at' => now(), 'updated_at' => now(), 'message' => 'Default message'],
            ['type' => "remove_club_member_request", 'day' => NULL, 'month' => NULL, 'enable_sending' => '1', 'send_on_schedule' => '0',
                'day2' => NULL, 'month2' => NULL, 'send_on_schedule2' => '0', 'created_at' => now(), 'updated_at' => now(), 'message' => 'Default message'],
            ['type' => "report_submitted", 'day' => NULL, 'month' => NULL, 'enable_sending' => '1',
                'send_on_schedule' => '0', 'day2' => NULL, 'month2' => NULL, 'send_on_schedule2' => '0',
                'created_at' => now(), 'updated_at' => now(), 'message' => 'Default message'],
            ['type' => "report_dismissed", 'day' => NULL, 'month' => NULL, 'enable_sending' => '1', 'send_on_schedule' => '0',
                'day2' => NULL, 'month2' => NULL, 'send_on_schedule2' => '0', 'created_at' => now(), 'updated_at' => now(), 'message' => 'Default message'],
        ]);
    }
}
