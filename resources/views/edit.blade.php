@extends('layouts.app')

@section('content')
    <x-common.blog-navbar />
    <div class="container mt-4">
        <h1>Edit Post</h1>
        <x-form.post-edit :post="$post"/>
    </div>
@endsection
@section('script')
    <script src="{{ asset('editScript.js') }}"></script>
@endsection