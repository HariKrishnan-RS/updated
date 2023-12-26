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

    public function MainPage(request $request){
        if($request->has("tagsearch" ) and $request->tags){
            $tags = Tag::all();
            $postIds = array_map('intval',  $request->tags);
            $posts = Post::whereHas('tags', function ($query) use ($postIds) {
                $query->whereIn('tag_id', $postIds);
            })->where('title', 'like', "%$request->searchbox%")->get();
            return view("blog",['posts' => $posts,'tags'=>$tags,'tagArray'=>$postIds]);
        }
        else{
               $posts = Post::where('title', 'like', "%$request->searchbox%")->get();
               $tags = Tag::all();
               return view("blog",['posts' => $posts,'tags'=>$tags]);
            }
    }
    public function readPage(Request $request,$id){
        dd($request);
        $post = Post::find($id);
        $join = Join::where('post_id', $id)->first();
        $user_id = $join->user_id;
        $user = User::find($user_id);
        $comments = Comment::all()->where('post_id', $post->id);

        return view("read",['id'=>$id,'post' => $post,'user_name'=>$user->name,'comments'=>$comments]);
    }

   public function editPage($id){
       $post = Post::find($id);

        return view("edit",['post'=>$post]);

    }

    public function approve(request $request, $id){
//     if($request->has('rate')){
////         $request->rating
////
//         $rating = Rating::where('user_id', auth()->user()->id)
//             ->where('post_id', $id)
//             ->first();
//
//
//         if($request->rating == 1){
//             $rating->onestar =$rating->onestar + 1;
//         }
//         else if($request->rating == 2){
//             $rating->twostar =$rating->twostar + 1;
//         }
//         else if($request->rating == 3){
//             $rating->threestar =$rating->threestar+ 1;
//         }
//         else if($request->rating == 4){
//             $rating->fourstar = $rating->fourstar + 1;
//         }
//         else if($request->rating == 5){
//             $rating->fourstar =$rating->fourstar + 1;
//         }
//         $rating->save();
////         dd("done");
//     }
     if($request->has('comment')){
        $newComment = new Comment();
        $newComment->comment = $request->input('comment');
        $newComment->user_id = auth()->user()->id;
        $newComment->post_id = $id;
        $newComment->save();
        return redirect()->back()->with('addedComment','comment added successfully');
     }
     else{
            if($request->has('delete')){
                $post = Post::find($id);
                $post->delete();
                return redirect()->route('blog.page')->with('delete','successfully deleted');
            }
            else{
                $post = Post::find($id);
                $post->approved = true;
                $post->save();
                $userEmail = "harikrishnan.radhakrishnan@qburst.com";
                Mail::to($userEmail)->send(new conformNotification());
                return redirect()->route('pending.page')->with('approve','success fully approved');
            }
      }
    }


public function draftPage($id){
    $draft = Draft::where('user_id', $id)->first();
    if($draft){
    $postId = $draft->post_id;
    // $draft->delete();
    $post = Post::find($postId);
    // $post->delete();
    $tags = Tag::all();
     return view('draft',['post'=>$post,'tags'=>$tags]);
    }
    // $posts = Post::all();
    // return view("blog",['posts' => $posts]);
    return redirect()->back()->with('draftMsg','No draft available');
}

    public function addPost(){
        $tags = Tag::all();
        return view("add",['tags'=>$tags]);
    }

    public function pendingPage(){
               $posts = Post::all();
               return view("pending",['posts' => $posts]);
    }

}
//service folder
