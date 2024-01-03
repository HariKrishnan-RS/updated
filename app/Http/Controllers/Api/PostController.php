<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\conformNotification;
use App\Mail\NewPostNotification;
use App\Models\Comment;
use App\Models\Draft;
use App\Models\Join;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Tagjoin;
use App\Models\User;
use ErrorException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class PostController extends Controller
{
    public function show(Request $request,$id){

            try {
                $token = JWTAuth::getToken();
            } catch (JWTException $exception) {
                throw new UnauthorizedHttpException('jwt-auth', 'Token is missing or invalid');
            }
            $post = Post::findOrFail($id);
            $join = Join::where('post_id', $id)->first();
            $user = User::find($join->user_id);
            $comments = Comment::all()->where('post_id', $post->id);
        if($request->has('json') && JWTAuth::check($token))
        {
            return $post;
        }
            return view("read",['id'=>$id,'post' => $post,'user_name'=>$user->name,'comments'=>$comments]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'small_description' => 'required|string|max:500',
            'full_description' => 'required|string',
            'image' => 'required',
        ]);

        if ( $request->has('image'))
        {

            $post = new Post();
            $post->title = $request->title;
            $post->small_description = $request->small_description;
            $post->full_description = $request->full_description;
            $post->draft = $request->has('asDraft');
            $post->save();

            if( !$request->has('asDraft'))
            {
                foreach($request->tags as $id)
                {
                    $tagjoin = new Tagjoin;
                    $tagjoin->post_id = $post->id;
                    $tagjoin->tag_id = $id;
                    $tagjoin->save();
                }
                $userEmail = "harikrishnan.radhakrishnan@qburst.com";
                Mail::to($userEmail)->queue(new NewPostNotification());
            }

            auth()->user()->posts()->attach($post); //update joins table
            return "successfully posted";
        }
        return "Posting Failed";
    }

    public function edit(Request $request,$id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'small_description' => 'required|string|max:500',
            'full_description' => 'required|string',
        ]);

        try {
            $token = JWTAuth::getToken();
        } catch (JWTException $exception) {
            throw new UnauthorizedHttpException('jwt-auth', 'Token is missing or invalid');
        }
        $json = JWTAuth::getPayload($token)->toArray();
        $sub = $json['sub'];
        $user = User::find($sub);


        if( $request->has('edit') && $user->role =="editor")
        {
            $post = Post::find($id);
            $post->title = $request->title;
            $post->small_description = $request->small_description;
            $post->full_description = $request->full_description;
            $post->save();
            return response()->json(["status"=>"ok","msg"=>"Post Successfully Updated"]);
            //return redirect()->route('blog.index')->with('edited', 'Post Edited successfully');
        }
        else
        {
            if($user->role =="editor")
            {
                return response()->json(["status" => "failed", "msg" => "Missing 'edit'"]);
            }
            else
            {
                return response()->json(['error' => 'Unauthorized',"msg"=>"Editor level required"], Response::HTTP_UNAUTHORIZED);
            }
        }

    }

    public function update(Request $request,$id)
    {
        try {
            $token = JWTAuth::getToken();
        } catch (JWTException $exception) {
            throw new UnauthorizedHttpException('jwt-auth', 'Token is missing or invalid');
        }
        $json = JWTAuth::getPayload($token)->toArray();
        $sub = $json['sub'];
        $user = User::find($sub);
        if( $request->has('approve') && $user->role =="admin")
        {
            try {
                $post = Post::find($id);
                if ($post->approved){ return response()->json(["status"=>"failed","msg"=>"Already Approved Post"]);}
                $post->approved = true;
                $post->save();
                $userEmail = "harikrishnan.radhakrishnan@qburst.com";
                Mail::to($userEmail)->queue(new conformNotification());
                return response()->json(["status"=>"ok","msg"=>"Post Status Updated to 'Approved'"]);
            }catch (ModelNotFoundException $e) {
                return response()->json(["status"=>"failed","msg"=>"No record found"]);
            }catch (ErrorException $e) {
                return response()->json(["status"=>"failed","msg"=>"Attempted to read null property: approved"]);
            }catch (Exception $e) {

                return response()->json(["status"=>"failed","msg"=>"Something went wrong"]);
            }
        }
        else
        {
            if($user->role =="admin")
            {
                return response()->json(["status" => "failed", "msg" => "Missing 'approved'"]);
            }
            else
            {
                return response()->json(['error' => 'Unauthorized',"msg"=>"Admin level required"], Response::HTTP_UNAUTHORIZED);
            }

        }
    }
    public function destroy(Request $request,$id)
    {
        $token = JWTAuth::getToken();
        $json = JWTAuth::getPayload($token)->toArray();
        $sub = $json['sub'];
        $user = User::find($sub);
        if ( $user->role == "admin")
        {
            try {
                $post = Post::findOrFail($id);
                $post->delete();
                return response()->json(["status"=>"ok","msg"=>"Post Successfully deleted"]);
            } catch (ModelNotFoundException $e) {
                return response()->json(["status"=>"failed","msg"=>"No record found"]);
            } catch (Exception $e) {
                return response()->json(["status"=>"failed","msg"=>"Something went wrong"]);

            }
        }
        else{
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function view(Request $request)
    {
        $tags = Tag::all();
        return view('create',['tags'=>$tags]);
    }

}
