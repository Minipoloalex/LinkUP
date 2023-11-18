<form class="add-{{ $type }}">
    <input type="text" name="content" required placeholder="Add a new {{ $type }}">
    <button type="submit">Add a new {{ $type }}</button>    <!-- MUST BE FIRST ON THE HTML -->
    <div class="file-input-wrapper">
        <button class="upload-file">Upload image</button>
        <input type="file" accept=".jpg, .jpeg, .png, .gif, .mp4" class="hidden" name="media">
        <button class="remove-file hidden">Clear image</button>
        <span class="file-name">No file selected</span>
    </div>
</form>
