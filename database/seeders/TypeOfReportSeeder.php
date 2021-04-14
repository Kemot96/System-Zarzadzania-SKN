<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeOfReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_of_report')->insert([
            ['name' => "Sprawozdanie", 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Plan działań", 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
