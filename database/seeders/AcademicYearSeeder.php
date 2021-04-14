<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('academic_years')->insert([
            ['name' => "2019/2020", 'current_year' => '0' ,'created_at' => now(), 'updated_at' => now()],
            ['name' => "2020/2021", 'current_year' => '1' ,'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
