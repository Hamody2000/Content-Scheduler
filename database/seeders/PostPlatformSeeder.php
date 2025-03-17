<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PostPlatform;
use Carbon\Carbon;

class PostPlatformSeeder extends Seeder
{
    public function run(): void
    {
        PostPlatform::create([
            'title' => 'Test Post for Facebook',
            'content' => 'This is a test post for Facebook!',
            'image' => null,
            'platform' => 'facebook',
            'scheduled_at' => Carbon::now()->addMinutes(10),
            'status' => 'scheduled',
        ]);
    }
}

