@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Post</h1>
        <x-form.post-edit :post="$post"/>
    </div>
@endsection
@section('script')
    <script src="{{ asset('editScript.js') }}"></script>
@endsection