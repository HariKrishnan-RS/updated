<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Join;
use App\Models\Rating;
use App\Models\Tagjoin;
use App\Models\User;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\Draft;
use Illuminate\Http\Request;
use App\Mail\conformNotification;
use Illuminate\Support\Facades\Mail;
class PageController extends Controller
{

    public function show(){

               return view("api.pending");
    }

}

