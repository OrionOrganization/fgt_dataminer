<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = config('backpack.permissionmanager.permissions_list');
        
        foreach($permissions as $name) {
            Permission::updateOrCreate(['name' => $name], ['name' => $name]);
        }
    }
}
