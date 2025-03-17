<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Bus\Queueable;
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
        Log::info('PublishScheduledPosts job started');

        $now = \Carbon\Carbon::now();
        $posts = Post::where('status', 'scheduled')
            ->where('scheduled_time', '<=', $now)
            ->get();

        foreach ($posts as $post) {
            try {
                $this->mockPublishingService($post);
                Log::info("Publishing post: " . $post->title);
                $post->update(['status' => 'published']);
            } catch (\Exception $e) {
                Log::error("Failed to publish post: " . $post->title . " - " . $e->getMessage());
            }
        }

        Log::info('PublishScheduledPosts job finished');
    }
    private function mockPublishingService($post)
    {
        // Simulating a 2-second delay as if it's calling an external API
        sleep(2);

        // Log instead of actually publishing
        Log::info("Mock: Publishing post '{$post->title}' on {$post->platform}");
    }
}
