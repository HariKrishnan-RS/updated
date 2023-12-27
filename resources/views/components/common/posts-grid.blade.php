@props(['posts'])

<div class="m-4 gap-4 card-pack" id="card-pack">
    @foreach($posts as $post)
        @if($post->approved && !$post->draft)
            <x-common.post-card :post="$post" />
        @endif
    @endforeach
</div>