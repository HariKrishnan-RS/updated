@props(['userRole'])

@if($userRole === 'admin')
    <div class="d-flex align-items-center justify-content-center flex-column">
        <a href="{{ route('pending.show') }}" class="btn btn-warning text-decoration-none" id="pendingbtn">Pending posts</a>
    </div>
@endif