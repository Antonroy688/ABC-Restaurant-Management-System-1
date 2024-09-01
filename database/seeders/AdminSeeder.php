<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user=new User;
        $user->name='SuperAdmin';
        $user->email='admin@admin.com';
        $user->password=Hash::make('password');
        $user->save();

        $user->assignRole('Super Admin');
    }
}
