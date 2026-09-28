<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * The home page of the impersonated user, with their unread, not expired notifications
     * when on-screen notifications are switched on.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        // With on-screen notifications switched off there is no bell, so nothing to load.
        $notifications = $user->notifications_enabled
            ? $user->notificationPosts()
                ->notExpired()
                ->wherePivotNull('read_at')
                ->latest()
                ->get()
            : collect();

        return view('home.index', [
            'user' => $user,
            'notifications' => $notifications,
        ]);
    }
}
