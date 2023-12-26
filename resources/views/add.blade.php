 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


</head>
<body>
 <div class="container">
        <h1>Add Post</h1>
        <form method="POST" action="{{ route('store.post') }}"  enctype="multipart/form-data">
          {{--  --}}
            @csrf
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
             @foreach($tags as $tag)
               <input type="checkbox" id="tag_{{ $tag->id }}" name="tags[]" value="{{ $tag->id }}">
               <label for="tag_{{ $tag->id }}">{{ $tag->tagName }}</label><br>
             @endforeach

            <!-- Submit and Save as Draft Buttons -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="submit" class="btn btn-secondary" name="asDraft">Save as Draft</button>
            </div>
        </form>
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="{{ asset('script.js') }}"></script>

</body>
</html>