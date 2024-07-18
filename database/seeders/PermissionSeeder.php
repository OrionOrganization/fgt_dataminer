<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('permission_list') as $key => $name) {
            Permission::updateOrCreate(
                ['name' => $name],
            );
        }

        Permission::whereNotIn('name', config('permission_list'))->delete();
    }
}

