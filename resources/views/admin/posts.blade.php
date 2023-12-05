@extends('layouts.admin')

@section('content')
@foreach($posts as $post)

<div class="flex mt-4 content-center justify-center items-center w-full mx-auto">
    @include('partials.post', ['post' => $post, 'displayComments' => false, 'showEdit' => false])

    <div class="flex flex-col justify-center items-center w-1/3">
        <form action="{{ route('admin.posts.delete', ['id' => $post->id]) }}" method="POST">
            @csrf

            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Delete
            </button>
        </form>
    </div>

</div>

    






@endforeach

{{ $posts->links() }}

@endsection