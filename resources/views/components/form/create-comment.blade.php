<div>
    <form class="form" method="POST" action="{{ route('post.update',['id'=>$post->id]) }}">
        @csrf

        <label class="comment-label" for="comment">Your Comment:</label>
        <input type="text" class="form-control" id="comment" name="comment" required >
        <button class="btn btn-primary mt-1"  type="submit" name='commentbtn' id="commentbtn">Add Comment</button>
    </form>
</div>