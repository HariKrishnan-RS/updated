<form method="POST" action="{{ route('blog.index') }}">
    @csrf
    <button class="btn-secondary" type="submit" id="logoutbtn">Logout</button>
</form>