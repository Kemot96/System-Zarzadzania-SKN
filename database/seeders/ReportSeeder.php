<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\TypeOfReport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clubs = Club::all();

        foreach($clubs as $club)
        {
            DB::table('reports')->insert([
                ['clubs_id' => $club->id, 'academic_years_id' => getCurrentAcademicYear()->id,
                    'types_id' => TypeOfReport::getReportID(), 'supervisor_approved' => NULL, 'secretariat_approved' => NULL,
                    'vice-rector_approved' => NULL, 'created_at' => now(), 'updated_at' => now()],
                ['clubs_id' => $club->id, 'academic_years_id' => getCurrentAcademicYear()->id,
                    'types_id' => TypeOfReport::getSpendingPlanID(), 'supervisor_approved' => NULL, 'secretariat_approved' => NULL,
                    'vice-rector_approved' => NULL, 'created_at' => now(), 'updated_at' => now()],
                ['clubs_id' => $club->id, 'academic_years_id' => getCurrentAcademicYear()->id,
                    'types_id' => TypeOfReport::getActionPlanID(), 'supervisor_approved' => NULL, 'secretariat_approved' => NULL,
                    'vice-rector_approved' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
    }
}
