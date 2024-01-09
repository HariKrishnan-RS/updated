<?php

namespace App\Http\Controllers;

use App\Jobs\mail;
use App\Jobs\NewUserWelcomeMail;
use App\Mail\NewPostNotification;
use App\Mail\WelcomeEmail;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //
    public function index( request $request ): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
 return view("api.z-blog");
    }
}
