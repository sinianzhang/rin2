<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * List all users, sorted alphabetically by name.
     */
    public function index(): View
    {
        $users = User::query()
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'phone_number']);

        return view('users.index', ['users' => $users]);
    }
}
