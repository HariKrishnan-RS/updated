@props(['post'])

<form method="POST" action="{{ route('post.edit',['id'=>$post->id]) }}"  enctype="multipart/form-data">

    @csrf
    @method('PATCH')
    <!-- Title -->
    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" class="form-control" id="title" name="title" required value='{{$post->title}}'>
    </div>

    <!-- Small Description -->
    <div class="form-group">
        <label for="small_description">Small Description:</label>
        <textarea class="form-control" id="small_description" name="small_description" rows="3" required>
                  {{$post->small_description}}
        </textarea>
    </div>

    <!-- Full Description -->
    <div class="form-group">
        <label for="full_description">Full Description:</label>
        <textarea class="form-control" id="full_description" name="full_description" rows="5" required>
                  {{$post->full_description}}
        </textarea>
    </div>

    {{-- <!-- Image Upload -->
    <div class="form-group">
        <label for="image">Upload Image:</label>
        <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
    </div> --}}

    <!-- Submit and Save as Draft Buttons -->
    <div class="form-group mt-3">
        <button type="submit" class="btn btn-primary" name="edit">Edit</button>
        <button type="submit" class="btn btn-secondary" name="back">Back</button>
    </div>
</form>