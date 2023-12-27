@props(['tags'])

@foreach($tags as $tag)
    <input type="checkbox" id="tag_{{ $tag->id }}" name="tags[]" value="{{ $tag->id }}">
    <label for="tag_{{ $tag->id }}">{{ $tag->tagName }}</label><br>
@endforeach