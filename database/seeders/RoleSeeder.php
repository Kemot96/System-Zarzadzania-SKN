<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'opiekun_koła', 'special_role' => '0', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'członek_koła', 'special_role' => '0', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'przewodniczący_koła', 'special_role' => '0', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'sekretariat_prorektora', 'special_role' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'prorektor', 'special_role' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'nieaktywny', 'special_role' => '0', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'admin', 'special_role' => '1', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
