<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Str;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $GroupNames=[
            // -----------------Users------------------
            [
                'name'=>'Users Create',
                'group_id'=>PermissionGroup::where('name','Users Management')->first()->id
            ],
            [
                'name'=>'Users View',
                'group_id'=>PermissionGroup::where('name','Users Management')->first()->id
            ],
            [
                'name'=>'Users Edit',
                'group_id'=>PermissionGroup::where('name','Users Management')->first()->id
            ],
            [
                'name'=>'Users Delete',
                'group_id'=>PermissionGroup::where('name','Users Management')->first()->id
            ],
            // --------------------Roles---------------------
            [
                'name'=>'Roles Create',
                'group_id'=>PermissionGroup::where('name','Roles and Permission Management')->first()->id
            ],
            [
                'name'=>'Roles View',
                'group_id'=>PermissionGroup::where('name','Roles and Permission Management')->first()->id
            ],
            [
                'name'=>'Roles Edit',
                'group_id'=>PermissionGroup::where('name','Roles and Permission Management')->first()->id
            ],
            [
                'name'=>'Roles Delete',
                'group_id'=>PermissionGroup::where('name','Roles and Permission Management')->first()->id
            ],
            // // ------------------Permission---------------------
            // [
            //     'name'=>'Permission Create',
            //     'group_id'=>PermissionGroup::where('name','Permission Management')->first()->id
            // ],
            // [
            //     'name'=>'Permission View',
            //     'group_id'=>PermissionGroup::where('name','Permission Management')->first()->id
            // ],
            // [
            //     'name'=>'Permission Edit',
            //     'group_id'=>PermissionGroup::where('name','Permission Management')->first()->id
            // ],
            // [
            //     'name'=>'Permission Delete',
            //     'group_id'=>PermissionGroup::where('name','Permission Management')->first()->id
            // ],
            // ------------------Zone---------------------
            [
                'name'=>'Zone Create',
                'group_id'=>PermissionGroup::where('name','Zone Management')->first()->id
            ],
            [
                'name'=>'Zone View',
                'group_id'=>PermissionGroup::where('name','Zone Management')->first()->id
            ],
            [
                'name'=>'Zone Edit',
                'group_id'=>PermissionGroup::where('name','Zone Management')->first()->id
            ],
            [
                'name'=>'Zone Delete',
                'group_id'=>PermissionGroup::where('name','Zone Management')->first()->id
            ],
            // ------------------Others---------------------
            [
                'name'=>'Dashboard View',
                'group_id'=>PermissionGroup::where('name','Others')->first()->id
            ],
            [
                'name'=>'Activity Log',
                'group_id'=>PermissionGroup::where('name','Others')->first()->id
            ],
            [
                'name'=>'Active Users',
                'group_id'=>PermissionGroup::where('name','Others')->first()->id
            ],
            [
                'name'=>'General Settings',
                'group_id'=>PermissionGroup::where('name','Others')->first()->id
            ],
            [
                'name'=>'Zone Permission Management',
                'group_id'=>PermissionGroup::where('name','Others')->first()->id
            ],
           
            
        ];
        foreach ($GroupNames as $key => $value) {
            $permissionGroup=new Permission();
            $permissionGroup->name=$value['name'];
            $permissionGroup->permission_group_id=$value['group_id'];
            $permissionGroup->save();
        }
    }
}
