@props(['tags'])

@foreach($tags as $tag)
    <div class="d-flex align-items-center justify-content-center flex-column p-1">
        <input type="checkbox" class="btn-check" id="tag_{{ $tag->id }}" name="tags[]" value="{{ $tag->id }}" autocomplete="off">
        <label style="font-size:15px" class="btn btn-outline-primary" for="tag_{{ $tag->id }}">{{ $tag->tagName }}</label>
    </div>
@endforeach