@if(session($key))
    <div class="alert alert-{{ $type }} mt-1" role="alert">
        {{ session($key) }}
    </div>
@endif