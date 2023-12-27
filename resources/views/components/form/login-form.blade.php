<form method="POST" action="{{ route('login.show') }}">
    @csrf
    <div class="row mb-3">
        <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>

        <div class="col-md-6">
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        </div>
    </div>

    <div class="row mb-3">
        <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>

        <div class="col-md-6">
            <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">

        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6 offset-md-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">
                    Remember Me
                </label>
            </div>
        </div>
    </div>

    <div class="row mb-0">
        <div class="col-md-8 offset-md-4">
            <button type="submit" class="btn btn-primary">
                Login now
            </button>
            <a href = "{{route('register.show')}}" class="btn btn-primary">
                Register
            </a>
        </div>
    </div>
</form>