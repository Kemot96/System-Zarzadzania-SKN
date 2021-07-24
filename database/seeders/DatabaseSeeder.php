<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            //InstituteSeeder::class,
            //UserSeeder::class,
            //RoleSeeder::class,
            //ClubSeeder::class,
            //SectionSeeder::class,
            //AcademicYearSeeder::class,
            //ClubMemberSeeder::class,
            //SectionMemberSeeder::class,
            //TypeOfReportSeeder::class,
            EmailSeeder::class,
        ]);
    }
}
