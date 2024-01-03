@props(['tags','post'])

<form method="POST" action="{{ route('draft.update',['id'=>$post->id]) }}"  enctype="multipart/form-data">
    @csrf

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
                  {{$post->full_description}}</textarea>
    </div>

    <!-- Image Upload -->
    <div class="form-group">
        <label for="image">Upload Image:</label>
        <input type="file" class="form-control-file" id="image" name="image" accept="image/*" >
    </div>
    <label>Select Tags:</label><br>

    <x-common.tag-checkbox :tags="$tags" />

    <div class="form-group">
        <button type="submit" name="save" class="btn btn-primary" id="submitbtn">Submit</button>
        <button type="submit" class="btn btn-secondary" name="asDraft" id="backbtn">back</button>
    </div>
</form>