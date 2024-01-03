<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class CommentController extends Controller
{
    public function store(Request $request,$id)
    {
        if( $request->has('comment') )
        {
            $newComment = new Comment();
            $newComment->comment = $request->input('comment');
            try {
                $token = JWTAuth::getToken();
            } catch (JWTException $exception) {
                throw new UnauthorizedHttpException('jwt-auth', 'Token is missing or invalid');
            }
            $json = JWTAuth::getPayload($token)->toArray();
            $sub = $json['sub'];
            $user = User::find($sub);
            $newComment->user_id = $user->id;
            $newComment->post_id = $id;
            $newComment->save();
            return response()->json(["status"=>"ok","msg"=>"Comment added successfully"], Response::HTTP_OK);
        }else{
            return response()->json(["status"=>"failed","msg"=>"operation failed! missing argument"], Response::HTTP_OK);
        }
    }

    public function show(Request $request,$id)
    {

//        try {
//                $token = JWTAuth::getToken();
//         } catch (JWTException $exception) {
//                throw new UnauthorizedHttpException('jwt-auth', 'Token is missing or invalid');
//         }
        $token = JWTAuth::getToken();
        if($request->has('json') && JWTAuth::check($token))
        {
            $post =  Post::find($id);
            if($post)
            {return $post->comments;}
            else
            {return response()->json(["status"=>"failed","msg"=>"Post not Found"]);}
        }
        return response()->json(["status"=>"failed","msg"=>"Missing attribute 'json'"]);
    }

}
