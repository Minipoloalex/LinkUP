@php $linkTo = route('admin.user', ['username' => $user->username]) @endphp
<tr class="user-tr border-b border-dark-neutral">
    <td class="px-2">
        <a href="{{ $linkTo }}">{{ $user->id }}</a> {{-- Do not place the link outside of the
    <td> element. --}}
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
            @csrf
            <button type="submit"
                class="bg-green-500 hover:bg-green-700 text-white font-bold my-2 py-1 px-4 rounded">Unban</button>
        </form>
        @else
        <form action="{{ route('admin.users.ban', $user->id) }}" method="POST">
            @csrf
            <button type="submit"
                class="bg-orange-500 hover:bg-orange-700 text-white font-bold my-2 py-1 px-4 rounded">Ban</button>
        </form>
        @endif
    </td>
    <td>
        <form action="{{ route('admin.users.delete', $user->id) }}" method="POST">
            @csrf
            <button type="submit"
                class="bg-red-500 hover:bg-red-700 text-white font-bold my-2 py-1 px-4 rounded">Delete</button>
        </form>
    </td>
</tr>