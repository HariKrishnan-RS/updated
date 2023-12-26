<?php

namespace App\Http\Controllers\Auth;
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
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

       public function showLoginForm()
    {
        return view("login");
    }
       public function login(request $request)
    {
        // return view("blog");
    $credentials = $request->only('email', 'password');

 Auth::attempting(function ($credentials) {
    $user = User::where('email', $credentials->credentials['email'])->first();
    $user->role;
    return true; // Always return true here
});


    if (Auth::attempt($credentials)) {
        // dd($credentials);
        // Authentication successful
        // $user = User::where('email', $credentials['email'])->first();
        // $role = $user->role;
        return redirect()->route('blog.page')->with('login_message', 'Login successful!');
    }

    // Authentic

    return redirect()->back()->with('login_message', 'Login failed! Please try again.');

    }



       public function logout(request $request)
    {
    Auth::logout();
    return redirect()->back()->with('logout_message', 'Logged out successfully!');

    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
