<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * The home page of the impersonated user.
     */
    public function index(Request $request): View
    {
        return view('home.index', ['user' => $request->user()]);
    }
}
