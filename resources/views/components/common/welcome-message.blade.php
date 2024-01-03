@props(['role','name','id'])
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



@if(isset($role))
<div class="alert alert-primary mt-1" role="alert">
@if($role==='user')

    Welcome User: {{ $name }}
@elseif($role==='admin')
    Welcome Admin!

@elseif($role==='editor')
    Welcome Editor!
@else
    Welcome Guest!
@endif
</div>
@endif