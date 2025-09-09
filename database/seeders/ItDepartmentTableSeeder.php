<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ItDepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 部門のテーブル管理
         DB::table('it_departments')->insert([
            ['id' => 1, 'name' => 'Hardware'],
            ['id' => 2, 'name' => 'Software'],
            ['id' => 3, 'name' => 'Network'],
        ]);
    }
}
