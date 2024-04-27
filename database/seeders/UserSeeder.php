<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Phạm Xuân Tuyển',
            'email' => 'phamtuyenok2002@gmail.com',
            'password' => Hash::make('Tuyen10a6')
        ]);
    }
}
