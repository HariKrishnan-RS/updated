@auth
    <div class="alert alert-primary mt-1" role="alert">
        @if(auth()->user()->role === 'admin')
            Welcome Admin!
        @elseif(auth()->user()->role === 'editor')
            Welcome Editor!
        @else
            Welcome User: {{ auth()->user()->name }}
        @endif
    </div>
@endauth