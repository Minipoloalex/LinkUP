@php $linkTo = route('admin.user', ['username' => $user->username]) @endphp
<tr class="user-tr">
    <td>
        <a href="{{ $linkTo }}">{{ $user->id }}</a> {{-- Do not place the link outside of the <td> element. --}}
    </td>
    <td>
        <a href="{{ $linkTo }}">{{ $user->username }}</a>
    </td>
    <td>
        <a href="{{ $linkTo }}">{{ $user->name }}</a>
    </td>
    <td>
        <a href="{{ $linkTo }}">{{ $user->email }}</a>
    </td>
    
    <td>
        @if($user->is_banned)
        <form action="{{ route('admin.users.unban', $user->id) }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Unban</button>
        </form>
        @else
        <form action="{{ route('admin.users.ban', $user->id) }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Ban</button>
        </form>
        @endif
    </td>
</tr>