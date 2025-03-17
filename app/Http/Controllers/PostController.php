<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostPlatform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Platform;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image_url' => 'nullable|url',
            'scheduled_time' => 'required|date|after:now',
            'platforms' => 'required|array',
            'platforms.*' => 'exists:platforms,id',
        ]);

        // Fetch platform details for validation
        $platforms = Platform::whereIn('id', $request->platforms)->get();

        foreach ($platforms as $platform) {
            if ($platform->type === 'twitter' && strlen($request->content) > 280) {
                return response()->json(['error' => 'Twitter posts must be 280 characters or less.'], 422);
            }

            if ($platform->type === 'linkedin' && strlen($request->content) > 3000) {
                return response()->json(['error' => 'LinkedIn posts must be 3000 characters or less.'], 422);
            }
        }

        // Create the post
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'image_url' => $request->image_url,
            'scheduled_time' => $request->scheduled_time,
            'status' => 'draft',
            'user_id' => Auth::id(),
        ]);

        // Attach platforms
        $post->platforms()->syncWithPivotValues($request->platforms, ['platform_status' => 'pending']);

        return response()->json(['message' => 'Post created successfully', 'post' => $post], 201);
    }

    public function index(Request $request)
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $query = Post::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('date')) {
            $query->whereDate('scheduled_time', $request->date);
        }

        $posts = $query->where('user_id', Auth::id())->get();

        return response()->json($posts);
    }
    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'image_url' => 'nullable|url',
            'scheduled_time' => 'sometimes|date',
            'status' => 'in:draft,scheduled,published',
        ]);

        $post->update($request->all());

        return response()->json(['message' => 'Post updated', 'post' => $post]);
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $post->delete();
        return response()->json(['message' => 'Post deleted']);
    }

    public function show(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($post);
    }
}
