<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Platform;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Platform::create([
            'name' => 'Twitter',
            'type' => 'twitter',
        ]);

        Platform::create([
            'name' => 'Instagram',
            'type' => 'instagram', 
        ]);

        Platform::create([
            'name' => 'LinkedIn',
            'type' => 'linkedin', 
        ]);

        Platform::create([
            'name' => 'Facebook',
            'type' => 'facebook', 
        ]);
    }
}
