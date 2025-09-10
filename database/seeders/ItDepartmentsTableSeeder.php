<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\ItDepartment;

class ItDepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 部門のテーブル管理
        $departments = [
            ['id'=>1, 'code' => 'hardware', 'name' => 'Hardware'],
            ['id'=>2, 'code' => 'software', 'name' => 'Software'],
            ['id'=>3, 'code' => 'network', 'name' => 'Network'],
        ];

        foreach ($departments as $dept) {
            DB::table('it_departments')->updateOrInsert(
                ['id' => $dept['id']], 
                ['code' => $dept['code'], 'name' => $dept['name']]
            );
    }
}
}
