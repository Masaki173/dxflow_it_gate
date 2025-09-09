<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 管理者データ管理
        $user = User::updateOrCreate([
            'name' => 'MasakiInami',
            'email' => 'Admin@xxx.com',
            'password' => Hash::make(env('ADMIN_PASSWORD')),
            'role_id' => 1,
        ]);
    }
}
