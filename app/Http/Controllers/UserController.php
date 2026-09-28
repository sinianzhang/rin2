<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * List all users, sorted alphabetically by name, with their unread, not expired notification count.
     */
    public function index(): View
    {
        // select() must come before withCount(); columns passed to get() would be ignored.
        $users = User::query()
            ->select(['id', 'name', 'email', 'phone_number', 'notifications_enabled'])
            ->withCount([
                'notificationPosts as notifications_count' => function (Builder $query) {
                    $query->notExpired();
                },
                'notificationPosts as unread_notifications_count' => function (Builder $query) {
                    $query->notExpired()->whereNull('notification_recipients.read_at');
                },
            ])
            ->orderBy('name')
            ->get();

        return view('users.index', ['users' => $users]);
    }
}
