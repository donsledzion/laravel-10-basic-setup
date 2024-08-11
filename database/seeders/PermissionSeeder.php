<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        Permission::create([
            'name' => 'create_admin'
        ]);
        Permission::create([
            'name' => 'remove_admin'
        ]);
        Permission::create([
            'name' => 'edit_admin'
        ]);
        Permission::create([
            'name' => 'create_organization'
        ]);
        Permission::create([
            'name' => 'edit_organization'
        ]);
        Permission::create([
            'name' => 'remove_organization'
        ]);
        Permission::create([
            'name' => 'create_organization_admin'
        ]);
        Permission::create([
            'name' => 'create_organization_trainer'
        ]);
        Permission::create([
            'name' => 'create_organization_manager'
        ]);
        Permission::create([
            'name' => 'see_organization_users'
        ]);
        Permission::create([
            'name' => 'create_scenario'
        ]);
        Permission::create([
            'name' => 'edit_scenario'
        ]);
        Permission::create([
            'name' => 'remove_scenario'
        ]);
        Permission::create([
            'name' => 'view_all_scenarios'
        ]);
        Permission::create([
            'name' => 'view_owned_scenarios'
        ]);
        Permission::create([
            'name' => 'set_organization_expiration_date'
        ]);
        Permission::create([
            'name' => 'remove_manager'
        ]);
        Permission::create([
            'name' => 'remove_trainer'
        ]);
        Permission::create([
            'name' => 'remove_organization_admin'
        ]);
    }
}
