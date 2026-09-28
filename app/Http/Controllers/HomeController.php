<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * The home page of the impersonated user, with their unread, not expired notifications.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $notifications = $user->notificationPosts()
            ->notExpired()
            ->wherePivotNull('read_at')
            ->latest()
            ->get();

        return view('home.index', [
            'user' => $user,
            'notifications' => $notifications,
        ]);
    }
}
