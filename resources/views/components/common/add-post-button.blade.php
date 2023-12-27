@props(['userRole'])

@if($userRole === 'user')
    <div class="d-flex align-items-center justify-content-center flex-column">
        <form method="GET" action="{{ route('addpost.show') }}" >
            <input type="hidden" name="create" value="1">
            <button type="submit" class="btn btn-success text-decoration-none">Add Post</button>
        </form>
        <a href="{{ route('draft.show', ['id' => auth()->user()->id]) }}" class="btn-alert">Draft</a>
    </div>
@endif