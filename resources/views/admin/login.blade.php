<form method="POST" action="{{ route('admin.login') }}">
    {{ csrf_field() }}

    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    @if ($errors->has('email'))
        <span class="error">
            {{ $errors->first('email') }}
        </span>
    @endif

    <label for="password">Password</label>
    <input id="password" type="password" name="password" required>
    @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
    @endif

    <button type="submit">
        Login
    </button>
</form>