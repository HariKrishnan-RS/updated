@props(['userRole','id'])

@if(isset($id))
@if($userRole === 'user')
    <div class="d-flex align-items-center justify-content-center flex-column">
        <form method="GET" action="{{ route('addpost.show') }}" >
            <input type="hidden" name="create" value="1">
            <button type="submit" class="btn btn-success text-decoration-none" id="addPostbtn">Add Post</button>
        </form>
        <a href="{{ route('draft.show', ['id' => $id]) }}" class="btn-alert" id="draftPostbtn">Draft</a>
    </div>
@else
    <div id="addPostbtn"></div>
    <div id="draftPostbtn"></div>
@endif
@endif