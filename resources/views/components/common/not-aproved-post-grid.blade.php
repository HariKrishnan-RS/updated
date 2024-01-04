@props(['posts'])

<div class="d-flex align-items-center justify-content-center gap-3">
    @foreach($posts as $post)
        @if(!$post->approved && !$post->draft)
            <div class="card mb-5 " style="max-width:300px; width: 100%; height:500px"  >
                <img src="{{ asset('images/post-img.jpg') }}" class="card-img card-img-top" alt="Placeholder Image">
                <div class="card-body">
                    <h5 class="card-title" >{{ $post->title }} </h5>
                    <p class="card-text" >{{ $post->small_description }}</p>
                    <!-- <p class="card-text">$post->full_description</p> -->
                    <a href="{{ route('post.show', ['id' => $post->id]) }}" class="btn btn-primary read" id="{{$post->id}}">Read</a>
                </div>
            </div>
        @endif
    @endforeach
</div>