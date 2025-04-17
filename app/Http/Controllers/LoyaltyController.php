<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoyaltyController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'platform' => 'required|string',
            'points' => 'required|integer',
        ]);

        $platform = $request->platform;
        $points = min(100, $request->points); // cap at 100

        $followed = $user->followed_platforms ?? [];

        if (!in_array($platform, $followed)) {
            $followed[] = $platform;
            $user->followed_platforms = $followed;
            $user->loyalty_points = $points;
            $user->save();
        }

        return response()->json([
            'success' => true,
            'points' => $user->loyalty_points,
            'followed' => $user->followed_platforms
        ]);
    }
}