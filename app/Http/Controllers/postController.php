<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Join;
use App\Models\Tagjoin;
use App\Models\Draft;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Mail\NewPostNotification;
use Illuminate\Support\Facades\Mail;
class postController extends Controller
{

    public function index()
    {
        $posts = Post::all(); // Retrieve all posts
        return response()->json($posts);
    }

public function draftPost(Request $request,$id) {
  if(!$request->has("asDraft")) {
  $post = Post::find($id);
  $post->draft = false;
  $post->save();
  foreach($request->tags as $idd){
          $tagjoin = new Tagjoin;
          $tagjoin->post_id = $post->id;
          $tagjoin->tag_id = $idd;
          $tagjoin->save();
  }
  $draft = Draft::where('post_id',$id);
  $draft->delete();
  return redirect()->route('blog.page');
  }
  else{
  return redirect()->route('blog.page');
  }
}

public function storePost(Request $request){

      $request->validate([
          'title' => 'required|string|max:255',
          'small_description' => 'required|string|max:500',
          'full_description' => 'required|string',
          'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',

      ]);



        if ($request->hasFile('image')) {

        $imageName = 'post-img1.' . $request->image->extension();
        $request->image->storeAs('images', $imageName, 'public');
        $post = new Post();
        $post->title = $request->title;
        $post->small_description = $request->small_description;
        $post->full_description = $request->full_description;
        if ($request->has('asDraft')) {
        $post->draft = true;
        } else {


        $post->draft = false;
        $userEmail = "harikrishnan.radhakrishnan@qburst.com";
        Mail::to($userEmail)->send(new NewPostNotification());
        }

        $post->save();
        if (!$request->has('asDraft')) {
        foreach($request->tags as $id){
          $tagjoin = new Tagjoin;
          $tagjoin->post_id = $post->id;
          $tagjoin->tag_id = $id;
          $tagjoin->save();
        }
      }
        $userId = Auth::id();
        $join = new Join();
        $join->user_id = $userId;
        $join->post_id = $post->id; // Use the newly created post's ID
        $join->save();
        if ($request->has('asDraft')) {
        $draft = new Draft();
        $postId = DB::table('posts') ->where('title', $request->title)->first()->id;
        $draft->post_id = $postId;
        $draft->user_id = Auth::user()->id;
        $draft->save();
      // dd('sss');
      }
        return redirect()->route('blog.page')->with('posted', 'Post created successfully');


      }
}
public function editPost(Request $request,$id)
{


    $request->validate([
        'title' => 'required|string|max:255',
        'small_description' => 'required|string|max:500',
        'full_description' => 'required|string',
    ]);

    if ($request->has('edit')) {
        $post = Post::find($id);
        $post->title = $request->title;
        $post->small_description = $request->small_description;
        $post->full_description = $request->full_description;
        $post->save();
        return redirect()->route('blog.page')->with('edited', 'Post Edited successfully');
    } else {
        return redirect()->route('blog.page')->with('edited', 'Editing Cancled');
    }

}
}
