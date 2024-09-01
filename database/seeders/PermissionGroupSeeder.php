<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $GroupNames=[
            [
                'name'=>'Users Management'
            ],
            [
                'name'=>'Roles and Permission Management'
            ],
            [
                'name'=>'Zone Management'
            ],
            [
                'name'=>'Others'
            ]
        ];
        foreach ($GroupNames as $key => $value) {
            $permissionGroup=new PermissionGroup();
            $permissionGroup->name=$value['name'];
            $permissionGroup->save();
        }
    }
}
