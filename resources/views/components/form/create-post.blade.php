@props(['tags'])

<form method="POST" action="{{ route('post.create') }}"  enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <!-- Title -->
    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>

    <!-- Small Description -->
    <div class="form-group">
        <label for="small_description">Small Description:</label>
        <textarea class="form-control" id="small_description" name="small_description" rows="3" required></textarea>
    </div>

    <!-- Full Description -->
    <div class="form-group">
        <label for="full_description">Full Description:</label>
        <textarea class="form-control" id="full_description" name="full_description" rows="5" required></textarea>
    </div>

    <!-- Image Upload -->
    <div class="form-group mt-3 mb-3">
        <label for="image">Upload Image:</label>
        <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
    </div>
    {{-- select tags --}}
    <label>Select Tags:</label><br>

    <x-common.tag-checkbox :tags="$tags" />

    <!-- Submit and Save as Draft Buttons -->
    <div class="form-group">
        <button type="submit" class="btn btn-primary" id="submitbtn">Submit</button>
        <button type="submit" class="btn btn-secondary" name="asDraft" id="draftbtn">Save as Draft</button>

    </div>
</form>
<button  class="btn btn-secondary" name="back" id="backbtn">back</button>