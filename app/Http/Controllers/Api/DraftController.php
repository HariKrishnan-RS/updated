<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\NewPostNotification;
use App\Models\Draft;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Tagjoin;
use App\Models\User;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class DraftController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|void
     */
    public function show(Request $request)
    {
        try {
            $token = JWTAuth::getToken();
        } catch (JWTException $exception) {
            throw new UnauthorizedHttpException('jwt-auth', 'Token is missing or invalid');
        }
        $json = JWTAuth::getPayload($token)->toArray();
        $sub = $json['sub'];
        $user = User::find($sub);
        if ($draft = Draft::where('user_id', $user->id)->first()) {
            $postId = $draft->post_id;
            $post = Post::find($postId);
            $tags = Tag::all();
            return view('draft', ['post' => $post, 'tags' => $tags]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'small_description' => 'required|string|max:500',
            'full_description' => 'required|string',
            //'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->has('draft'))
        {
            //$imageName = 'post-img1.' . $request->image->extension();
            //$request->image->storeAs('images', $imageName, 'public');
            if (Draft::where('user_id', '=', Auth::user()->id)) {


                $Draft = Draft::where('user_id', '=', Auth::user()->id)->first();
                if(isset($Draft->post_id))
                {
                    $post_Id = $Draft->post_id;
                    $Draft->delete();
                    Post::find($post_Id)->delete();
                }

            }
            $post = new Post();
            $post->title = $request->title;
            $post->small_description = $request->small_description;
            $post->full_description = $request->full_description;
            $post->draft = $request->has('draft');
            $post->save();


            $draft = new Draft();
            $postId = DB::table('posts')->where('title', $request->title)->first()->id;
            $draft->post_id = $postId;
            $draft->user_id = Auth::user()->id;
            $draft->save();

            auth()->user()->posts()->attach($post);
            return response()->json(["status" => "ok", "msg" => "Successfully Drafted"]);
        }
        else
        {
            return response()->json(["status" => "failed", "msg" => "Missing 'draft'"]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */

    public function edit(Request $request)
    {
        try {
            $token = JWTAuth::getToken();
        } catch (JWTException $exception) {
            throw new UnauthorizedHttpException('jwt-auth', 'Token is missing or invalid');
        }
        $json = JWTAuth::getPayload($token)->toArray();
        $sub = $json['sub'];
        $user = User::find($sub);


        $request->validate([
            'title' => 'required|string|max:255',
            'small_description' => 'required|string|max:500',
            'full_description' => 'required|string',
            'image' => 'required',
        ]);

        if ( $request->has('image'))
        {

            $Draft = Draft::where('user_id','=',$user->id)->first();
            if( !isset($Draft->post_id) )
            {
                return response()->json(["status" => "failed", "msg" => "User has no drafts to update"]);
            }
            $oldPost = Post::find($Draft->post_id);
            $oldPost->delete();

            $post = new Post();
            $post->title = $request->title;
            $post->small_description = $request->small_description;
            $post->full_description = $request->full_description;
            $post->draft = $request->has('draft');
            $post->save();

            if (!$request->has('draft'))
            {
                foreach ($request->tags as $id) {
                    $tagjoin = new Tagjoin;
                    $tagjoin->post_id = $post->id;
                    $tagjoin->tag_id = $id;
                    $tagjoin->save();
                }
                $userEmail = "harikrishnan.radhakrishnan@qburst.com";
                Mail::to($userEmail)->queue(new NewPostNotification());
            }

            auth()->user()->posts()->attach($post); //update joins table
            return response()->json(["status" => "ok", "msg" => "Post added successfully"]);
        }
    }
}