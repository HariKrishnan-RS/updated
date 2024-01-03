@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Post</h1>
        <x-form.create-post :tags="$tags"/>
    </div>
@endsection
@section('script')
    <script src="{{ asset('createPostScript.js') }}"></script>
@endsection
