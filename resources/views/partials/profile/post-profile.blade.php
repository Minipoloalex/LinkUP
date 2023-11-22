@foreach($user->posts as $post)
    @include('partials.post', ['post' => $post, 'displayComments' => false, 'showEdit' => false])
@endforeach