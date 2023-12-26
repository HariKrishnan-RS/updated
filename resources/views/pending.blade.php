<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="{{ asset('style.css') }}" rel="stylesheet">

</head>
<body >

<nav class="navbar navbar-expand-lg navbar-light bg-light top-nav">
  <a class="navbar-brand" href="#">BlogPage</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse link-list-div" id="navbarNav">
    <ul class="navbar-nav link-list">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Services</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Contact</a>
      </li>
    </ul>
  </div>
</nav>
<div class="pt-5 mb-3" ></div>

@if(session('approve'))
    <div class="alert alert-success mt-1" role="alert">
        {{ session('approve') }}
    </div>
@endif
<div class="d-flex align-items-center justify-content-center gap-3">
@foreach($posts as $post)
@if(!$post->approved && !$post->draft)
    <div class="card mb-5 " style="max-width:300px; width: 100%; height:500px"  >
        <img src="{{ asset('images/post-img.jpg') }}" class="card-img card-img-top" alt="Placeholder Image">
        <div class="card-body">
            <h5 class="card-title">{{ $post->title }}</h5>
            <p class="card-text" >{{ $post->small_description }}</p>
            <!-- If you want to display the full description in the card: -->
            <!-- <p class="card-text">{{ $post->full_description }}</p> -->
            
            <a href="{{ route('read.page', ['id' => $post->id]) }}" class="btn btn-primary" >Read</a>
        </div>
    </div>
@endif
@endforeach
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>