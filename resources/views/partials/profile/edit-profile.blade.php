<div class="profile-edit flex flex-row-reverse ml-4">
    <button id="editButton" class="bg-blue-500 hover:bg-black-700 text-black font-bold py-2 px-4 rounded-full">
        Edit
    </button>
</div>

<!-- Edit modal -->
<div id="editModal" class="edit-modal hidden fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex justify-center items-center">
    <div class="modal-content bg-white p-6 rounded shadow-lg">
        <h2 class="text-2xl font-bold mb-4">Edit Profile</h2>
        <form id="editForm" method="POST" action="{{ route('profile.update') }}">
            {{ csrf_field() }}

            <label for="name" class="block mb-2">Name</label>
            <input type="text" id="name" name="name" class="w-full border border-gray-300 rounded-md p-2 mb-4" value="{{ $user->name }}">
            @if ($errors->has('username'))
                <span class="error">
                    {{ $errors->first('username') }}
                </span>
            @endif
            
            <label for="username" class="block mb-2">Username</label>
            <input type="text" id="username" name="username" class="w-full border border-gray-300 rounded-md p-2 mb-4" value="{{ $user->username }}">
            @if ($errors->has('username'))
                <span class="error">
                    {{ $errors->first('username') }}
                </span>
            @endif
            
            <div class="flex justify-center">
                <button type="submit" class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded-full mr-1">Save</button>
                <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded-full" onclick="closeEditModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>
