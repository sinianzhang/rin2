<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonationController extends Controller
{
    /**
     * Act as the given user; there are no passwords, so this simply logs them in.
     */
    public function store(Request $request, User $user): RedirectResponse
    {
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home');
    }

    /**
     * Stop acting as a user and go back to the user list.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('users.index');
    }
}
