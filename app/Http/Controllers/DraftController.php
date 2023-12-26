<?php

namespace App\Http\Controllers;

use App\Models\Draft;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Tagjoin;
use Illuminate\Http\Request;

class DraftController extends Controller
{
    public function show( $id ): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        if( $draft = Draft::where('user_id', $id)->first() )
        {
            $postId = $draft->post_id;
            $post = Post::find($postId);
            $tags = Tag::all();
            return view('draft',['post'=>$post,'tags'=>$tags]);
        }
        return redirect()->back()->with('draftMsg','No draft available');
    }

    public function update( Request $request, $id ) {

        if( $request->has("save") )
        {
            $post = Post::find($id);
            $post->draft = false;
            $post->save();
            foreach($request->tags as $tag_id)
            {
                $tagjoin = new Tagjoin;
                $tagjoin->post_id = $post->id;
                $tagjoin->tag_id = $tag_id;
                $tagjoin->save();
            }
            $draft = Draft::where('post_id',$id);
            $draft->delete();
            return redirect()->route('blog.page');
        }
        else
        {
            return redirect()->route('blog.page');
        }
    }
}
