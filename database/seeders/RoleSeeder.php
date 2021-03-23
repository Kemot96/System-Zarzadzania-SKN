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
            ['name' => 'opiekun_koła', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'członek_koła', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'przewodniczący_koła', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'sekretariat_prorektora', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'prorektor', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'gość', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
