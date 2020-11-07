<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $activeListCount = $user->activeLists->count();
        $subscribersCount = $user->activeListsSubscribers()->count();
        $referralRate = $user->subscribersReferralRate();

        return Inertia::render('Dashboard', [
            'stats' => [
                'activeListCount' => $activeListCount,
                'subscribersCount' => $subscribersCount,
                'referralRate' => $referralRate,
            ],
        ]);
    }
}