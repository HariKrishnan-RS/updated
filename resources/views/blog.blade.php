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
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light top-nav">
  <a class="navbar-brand" href="#">blog</a>
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



<div class="blog-img-div">
<img class="blog-img" src="{{ asset('images/blog-img.jpg') }}" alt="blog">
<p class="my-blog-title">My Blog</p>
</div>
@auth
<div class="alert alert-primary mt-1" role="alert">
    @if(auth()->user()->role === 'admin')
        Welcome Admin!
    @elseif(auth()->user()->role === 'editor')
        Welcome editor!
    @else
        Welcome User: {{auth()->user()->name}}
    @endif
  </div>
@endauth

@if(session('draftMsg'))
    <div class="alert alert-danger mt-1" role="alert">
        {{ session('draftMsg') }}
    </div>
@endif
@if(session('login_message'))
    <div class="alert alert-success mt-1" role="alert">
        {{ session('login_message') }}
    </div>
@endif
@if(session('logout_message'))
    <div class="alert alert-success mt-1" role="alert">
        {{ session('logout_message') }}
    </div>
@endif
@if(session('posted'))
    <div class="alert alert-success mt-1" role="alert">
        {{ session('posted') }}
    </div>
@endif
{{-- tag search --}}
<form method="get" action="{{route('blog.page')}}"  enctype="multipart/form-data">
  <div class="d-flex justify-content-between p-3 flex-wrap " >
          @foreach($tags as $tag)
          <div class="d-flex align-items-center justify-content-center flex-column p-1">
            {{-- <input type="checkbox" class="btn-check" id="tag_{{ $tag->id }}" name="tags[]" value="{{ $tag->id }}"> --}}
            <input type="checkbox" class="btn-check" id="tag_{{ $tag->id }}" name="tags[]" value="{{ $tag->id }}" autocomplete="off">
            <label  style="font-size:15px"  class="btn btn-outline-primary" for="tag_{{ $tag->id }}">{{ $tag->tagName }}</label>
          </div>
          @endforeach
</div>
<div class="d-flex align-items-center justify-content-center flex-column">
    <input class="mb-2" id="searchForm" type="text" name="searchbox" placeholder="Search posts...">
<button class="btn btn-danger"  id="searchButton" type="submit" name="tag_search">Search</button>
</div>
</form>



<div class = "m-4 gap-4 card-pack" id="card-pack">
    @foreach($posts as $post)
@if($post->approved && !$post->draft)
    <div class="card">
        <img src="{{ asset('images/post-img.jpg') }}" class="card-img card-img-top" alt="Placeholder Image">
        <div class="card-body">
            <h5 class="card-title">{{ $post->title }}</h5>
            <p class="card-text">{{ $post->small_description }}</p>
            <!-- If you want to display the full description in the card: -->
            <!-- <p class="card-text">{{ $post->full_description }}</p> -->
            <a href="{{ route('read.page', ['id' => $post->id]) }}" class="btn btn-primary">Read</a>
        </div>
    </div>
@endif
@endforeach



</div>

@auth
<div class="d-flex align-items-center justify-content-center flex-column">
@if(auth()->user()->role === 'user')
<form method="GET" action="{{ route('add.page') }}" >
    <input type="hidden" name="create" value="1">
    <button type="submit"  class="btn btn-success text-decoration-none" >Add Post</button>
</form>
<a href="{{route('draft.page',['id'=> auth()->user()->id ])}}" class="btn-alert">Draft</a>
@endif
</div>

@endauth

@auth
<div class="d-flex align-items-center justify-content-center flex-column">
    @if(auth()->user()->role === 'admin')
   <a href="{{route('pending.page')}}" class="btn btn-warning text-decoration-none" >Pending posts</a>
    @endif
</div>
@endauth

@auth
@if(auth())
<form method="POST" action="{{ route('blog.page') }}">
    @csrf
    <button class="btn-secondary" type="submit">Logout</button>
</form>
@endif
@endauth
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="{{ asset('script.js') }}"></script>

</body>
</html>
