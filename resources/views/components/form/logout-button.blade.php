<form method="POST" action="{{ route('blog.index') }}">
    @csrf
    <button class="btn-secondary" type="submit">Logout</button>
</form>