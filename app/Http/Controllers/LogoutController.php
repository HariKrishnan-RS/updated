<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function update(): \Illuminate\Http\RedirectResponse
    {
        Auth::logout();
        return redirect()->back()->with('logout_message', 'Logged out successfully!');
    }

}
