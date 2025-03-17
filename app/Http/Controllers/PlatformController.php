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
        return response()->json(Platform::all());
    }

    public function toggle(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->platforms()->syncWithoutDetaching($request->platforms);

        return response()->json(['message' => 'Platforms updated']);
    }
}

