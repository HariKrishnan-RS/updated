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
        $tags = Tag::all();
        if( $request->has("tag_search" ) and $request->tags)
        {
            $postIds = array_map('intval',  $request->tags);
            $posts = Post::whereHas('tags', function ($query) use ($postIds) {
                $query->whereIn('tag_id', $postIds);
            })->where('title', 'like', "%$request->searchbox%")->get();
            return view("blog",['posts' => $posts,'tags'=>$tags,'tagArray'=>$postIds]);
        }
        else
        {
//            dispatch(new mail());
//            \Illuminate\Support\Facades\Mail::to("harikrishnan.radhakrishnan@qburst.com")->queue(new NewPostNotification());
//            mail::dispatch()->onQueue('database');
            $posts = Post::where('title', 'like', "%$request->searchbox%")->get();
            return view("blog",['posts' => $posts,'tags'=>$tags]);
        }
    }
}
