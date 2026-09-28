<?php

namespace App\Http\Controllers;

use App\Models\NotificationPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotificationReadController extends Controller
{
    /**
     * Mark the notification as read for the current user, which removes it from their list.
     */
    public function store(Request $request, NotificationPost $notificationPost): RedirectResponse
    {
        // Scoped to the current user's unread row: other users' rows and an earlier read_at stay untouched.
        $request->user()
            ->notificationPosts()
            ->wherePivotNull('read_at')
            ->updateExistingPivot($notificationPost->id, ['read_at' => now()]);

        // A user could have more than one notifications.
        // Reopen the dropdown after the redirect so several notifications can be dismissed in a row.
        return redirect()->route('home')->with('notifications_open', true);
    }
}
