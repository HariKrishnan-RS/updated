<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;
class PageController extends Controller
{
    public function index(Request $request)
    {
        $tags = Tag::all();
        if ($request->tags) {
            try {
                $token = JWTAuth::getToken();
            } catch (JWTException $exception) {
                throw new UnauthorizedHttpException('jwt-auth', 'Token is missing or invalid');
            }
            $json = JWTAuth::getPayload($token)->toArray();
            $sub = $json['sub'];
            $user = User::find($sub);

            if (is_string($request->tags)) {
                $postIds = explode(',',$request->tags);
            }
            else{
                $postIds = array_map('intval', $request->tags);
            }

            $posts = Post::whereHas('tags', function ($query) use ($postIds) {
                $query->whereIn('tag_id', $postIds);
            })->where('title', 'like', "%$request->searchbox%")->where('approved', true)->get();

            if ($request->has('json') && JWTAuth::check($token)) {
                $postsWithUsers = [];
                foreach ($posts as $post) {
                    $postWithUser = [
                        'post' => $post,
                        'user_details' => $post->users
                    ];
                    $postsWithUsers[] = $postWithUser;
                }
                return $postsWithUsers;
            }
//            return $posts;
            return view("blog", ['posts' => $posts, 'tags' => $tags, 'role' => $user->role, 'id' => $user->id, 'name' => $user->name]);
        } else {

            try {
                $token = JWTAuth::getToken();
            } catch (JWTException $exception) {
                throw new UnauthorizedHttpException('jwt-auth', 'Token is missing or invalid');
            }


            $json = JWTAuth::getPayload($token)->toArray();
            $sub = $json['sub'];
            $user = User::find($sub);
            $posts = Post::where('title', 'like', "%$request->searchbox%")->get();
            if ($request->has('json') && JWTAuth::check($token)) {
                return Post::with('users')
                    ->where('approved', true)
                    ->where('title', 'like', "%$request->searchbox%")
                    ->get();
            }
            return view("blog", ['posts' => $posts, 'tags' => $tags, 'role' => $user->role, 'id' => $user->id, 'name' => $user->name]);
        }


    }
    public function login(Request $request)
    {
        return "login";
    }
}
