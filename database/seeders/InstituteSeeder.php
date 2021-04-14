<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstituteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('institutes')->insert([
            ['name' => "Instytut Politechniczny", 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Instytut Informatyki Stosowanej im. Krzysztofa Brzeskiego", 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Instytut Ekonomiczny", 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Instytut Pedagogiczno-Językowy", 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
