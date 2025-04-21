<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LockerReservation;

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
        $followed = $user->followed_platforms ?? [];
        $alreadyFollowed = in_array($platform, $followed);
        $basePoints = $user->loyalty_points ?? 0;

        // ✅ Add platform to followed list if not already followed
        if (!$alreadyFollowed) {
            $followed[] = $platform;
            $basePoints += 25;
        }

        // ✅ Add another 25% if 8+ hours reached (only once)
        if ($this->hasReached8Hours($user->id)) {
            $basePoints = min(100, $alreadyFollowed ? $basePoints + 25 : $basePoints);
        }

        // Cap the points to 100
        $user->followed_platforms = $followed;
        $user->loyalty_points = min(100, $basePoints);
        $user->save();

        return response()->json([
            'success' => true,
            'points' => $user->loyalty_points,
            'followed' => $user->followed_platforms
        ]);
    }

    private function hasReached8Hours($userId)
    {
        $reservations = LockerReservation::where('user_id', $userId)
            ->where('payment_status', 'Paid')
            ->get();

        $totalSeconds = 0;

        foreach ($reservations as $reservation) {
            if ($reservation->reserved_at && $reservation->reserved_until) {
                $start = strtotime($reservation->reserved_at);
                $end = strtotime($reservation->reserved_until);
                $totalSeconds += ($end - $start);
            }
        }

        $totalHours = $totalSeconds / 3600;
        return $totalHours >= 8;
    }
    public function showLoyaltyPage()
{
    $user = Auth::user();

    // Check if the user already reached 8+ hours
    if ($this->hasReached8Hours($user->id)) {
        // If not already rewarded, grant the +25 bonus
        if ($user->loyalty_points < 100) {
            $bonus = 25;

            // Optional: Check if they followed all 3 platforms (75 points)
            $followed = $user->followed_platforms ?? [];
            if (count($followed) === 3) {
                $bonus = 25; // this completes the 100
            }

            $user->loyalty_points = min(100, ($user->loyalty_points ?? 0) + $bonus);
            $user->save();
        }
    }

    return view('loyalty');
}

}
