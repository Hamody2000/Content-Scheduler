<?php

namespace App\Http\Controllers;

use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PlatformController extends Controller
{
    public function index()
    {
        $platforms = Platform::all();
        $userId = Auth::id(); // Get authenticated user ID
        $user = User::find($userId);

        // Fetch user's active platforms
        $activePlatformIds = $user->platforms()->pluck('platforms.id')->toArray();

        // Add 'active' key to each platform
        $platforms = $platforms->map(function ($platform) use ($activePlatformIds) {
            $platform['active'] = in_array($platform->id, $activePlatformIds);
            return $platform;
        });

        return response()->json($platforms);
    }

    public function toggle(Platform $platform)
    {
        $userId = Auth::id(); // Get authenticated user ID
        $user = User::find($userId);

        // Check if the platform is currently associated with the user
        if ($user->platforms()->where('platforms.id', $platform->id)->exists()) {
            // Detach if it exists (deactivate)
            $user->platforms()->detach($platform->id);
            return response()->json(['message' => 'Platform deactivated']);
        } else {
            // Attach if it doesn't exist (activate)
            $user->platforms()->attach($platform->id);
            return response()->json(['message' => 'Platform activated']);
        }
    }
}
