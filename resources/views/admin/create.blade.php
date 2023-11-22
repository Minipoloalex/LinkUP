<form method="POST" action="{{ route('admin.create') }}">
    {{ csrf_field() }}

    <label for="name">Name</label>
    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
    @if ($errors->has('name'))
        <span class="error">
            {{ $errors->first('name') }}
        </span>
    @endif

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

    <label for="password_confirmation">Confirm Password</label>
    <input id="password_confirmation" type="password" name="password_confirmation" required>
    @if ($errors->has('password_confirmation'))
        <span class="error">
            {{ $errors->first('password_confirmation') }}
        </span>
    @endif

    <button type="submit">
        Create
    </button>

    @if (session('sucess'))
        <span class="success">
            {{ session('success') }}
        </span>
    @endif
</form>