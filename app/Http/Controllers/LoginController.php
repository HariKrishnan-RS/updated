<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Authenticatable;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function show()
    {
        return view("login");
    }
    public function update(request $request)
    {
        $credentials = $request->only('email', 'password');
        if ( Auth::attempt($credentials) )
        {
            return redirect()->route('blog.page')->with('login_message', 'Login successful!');
        }

        return redirect()->back()->with('login_message', 'Login failed! Please try again.');
    }






}
