<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $role=new Role;
       $role->name='Super Admin';
       $role->save();

       $permissions=Permission::get();

       foreach ($permissions as $key => $value) {
        $role->givePermissionTo($value->name);
       }
    }
}
