<?php

namespace Database\Seeders;

use App\Enums\UserRoles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Adam Chojaczyk',
            'email' => 'adam@ulinia8.pl',
            'email_verified_at' => Carbon::now(),
            'role' => UserRoles::ADMIN
        ]);
        User::create([
            'name' => 'Grzegorz Sokołowski',
            'email' => 'grzegorz@data.pl',
            'role' => UserRoles::ADMIN
        ]);
        User::create([
            'name' => 'Adam Sękowski',
            'email' => 'a.a.sekowski@gmail.com',
            'role' => UserRoles::ADMIN
        ]);
    }
}
