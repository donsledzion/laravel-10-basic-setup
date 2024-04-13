<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Organization;
use App\Models\Role;
use App\Enums\OrganizationRoles;

class OrganizationAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Bernard Grzyb',
            'email' => 'bernie@shroom.gr',
        ]);

        $ogranization = Organization::find(1);

        $ogranization->users()->attach($user,[
            'role_id' => Role::where('name','admin')->first()->id
        ]);

    }
}
