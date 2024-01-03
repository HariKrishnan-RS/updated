<?php

namespace App\Http\Controllers;
use App\Mail\conformNotification;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Join;
use App\Models\Tag;
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

    public function show(Request $request, $id = null )
    {

        if( $request->has('create') )
        {
            $tags = Tag::all();
            return view("create",['tags'=>$tags]);
        }
        else if( $request->has('edit')  )
        {
            $post = Post::find($id);
            return view("edit",['post'=>$post]);
        }
        else                                                    //read post
        {
            $post = Post::find($id);
            $join = Join::where('post_id', $id)->first();
            $user = User::find($join->user_id);
            $comments = Comment::all()->where('post_id', $post->id);
            return view("read",['id'=>$id,'post' => $post,'user_name'=>$user->name,'comments'=>$comments]);
        }

    }

    public function update( request $request, $id )
    {
        if( $request->has('comment') )
        {
            $newComment = new Comment();
            $newComment->comment = $request->input('comment');
            $newComment->user_id = auth()->user()->id;
            $newComment->post_id = $id;
            $newComment->save();
            return redirect()->back()->with('addedComment','comment added successfully');
        }

        if( $request->has('approve') )
        {
            $post = Post::find($id);
            $post->approved = true;
            $post->save();
            $userEmail = "harikrishnan.radhakrishnan@qburst.com";
            Mail::to($userEmail)->send(new conformNotification());
            return redirect()->route('pending.show')->with('approve', 'success fully approved');
        }
        return redirect()->back();
    }


    public function delete(  $id )
    {
        $post = Post::find($id);
        $post->delete();
        return redirect()->route('blog.index')->with('delete','successfully deleted');
    }



    public function create( Request $request )
    {

          $request->validate([
              'title' => 'required|string|max:255',
              'small_description' => 'required|string|max:500',
              'full_description' => 'required|string',
              'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
          ]);

          if ( $request->hasFile('image') && $request->file('image')->isValid())
          {
                $imageName = 'post-img1.' . $request->image->extension();
                $request->image->storeAs('images', $imageName, 'public');

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
                    Mail::to($userEmail)->send(new NewPostNotification());
                }

                if( $request->has('asDraft'))
                {
                    $draft = new Draft();
                    $postId = DB::table('posts') ->where('title', $request->title)->first()->id;
                    $draft->post_id = $postId;
                    $draft->user_id = Auth::user()->id;
                    $draft->save();
                }

                auth()->user()->posts()->attach($post); //update joins table
                return redirect()->route('blog.index')->with('posted', 'Post created successfully');

          }
    }
    public function edit(Request $request,$id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'small_description' => 'required|string|max:500',
            'full_description' => 'required|string',
        ]);

        if ($request->has('edit'))
        {
            $post = Post::find($id);
            $post->title = $request->title;
            $post->small_description = $request->small_description;
            $post->full_description = $request->full_description;
            $post->save();
            return redirect()->route('blog.index')->with('edited', 'Post Edited successfully');
        }
        else
        {
            return redirect()->route('blog.index')->with('edited', 'Editing Cancled');
        }

    }

}
