<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Organization;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Organization::create([
            'name' => 'PZU Zdrowie',
            'prefix' => 'pzu',
            'expires_at' => '2024-12-30',
            'headset_login' => 'pzu_headset',
            'headset_pin' => '1234',
        ]);

        Organization::create([
            'name' => 'Visus VR',
            'prefix' => 'visus',
            'expires_at' => '2024-10-25',
            'headset_login' => 'visus_vr',
            'headset_pin' => '1234',
        ]);

        Organization::create([
            'name' => 'Ergo Hestia',
            'prefix' => 'hestia',
            'expires_at' => '2025-11-31',
            'headset_login' => 'hestia_vr',
            'headset_pin' => '3214',
        ]);

        Organization::create([
            'name' => 'Allegro',
            'prefix' => 'allegro',
            'expires_at' => '2024-10-10',
            'headset_login' => 'allegro_vr',
            'headset_pin' => '3352',
        ]);

        Organization::create([
            'name' => 'Brembo',
            'prefix' => 'brembo',
            'expires_at' => '2025-05-11',
            'headset_login' => 'brembo_vr',
            'headset_pin' => '3385',
        ]);

        Organization::create([
            'name' => 'Velvet Care',
            'prefix' => 'velvet',
            'expires_at' => '2025-05-11',
            'headset_login' => 'velvet_vr',
            'headset_pin' => '3385',
        ]);
    }
}
