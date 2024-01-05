@props(['post'])

@if($post->approved && !$post->draft)
    <div class="card">
        <img src="{{ asset('images/post-img.jpg') }}" class="card-img card-img-top" alt="Placeholder Image">
        <div class="card-body">
            <h5 class="card-title">{{ $post->title }}</h5>
            <p class="card-text" style="text-align: justify">{{ $post->small_description }}</p>
            <a href="{{ route('post.show', ['id' => $post->id]) }}" id="{{$post->id}}" class="btn btn-primary posts">Read</a>
        </div>
    </div>
@endif