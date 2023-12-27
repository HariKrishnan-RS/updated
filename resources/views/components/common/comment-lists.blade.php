@props(['comments'])

<div class="scrollable-div">
    @foreach($comments as $comment)
        <div class="row">
            <h3>{{($comment->user->name)}}</h3>
            <p>{{$comment->comment}}</p>
            @if($comment->created_at)
                <p class="date"> posted: {{ $comment->created_at->diffForHumans() }}</p>
            @endif
        </div>
    @endforeach
</div>