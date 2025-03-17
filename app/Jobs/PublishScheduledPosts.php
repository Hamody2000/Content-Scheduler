<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PublishScheduledPosts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $now = Carbon::now();

        // Get all due posts
        $posts = Post::where('status', 'scheduled')
            ->where('scheduled_time', '<=', $now)
            ->get();

        foreach ($posts as $post) {
            // Mock publishing process (simulating API integration)
            Log::info("Mock publishing post: " . $post->title);

            // Update post status to published
            $post->update(['status' => 'published']);
        }
    }
}
