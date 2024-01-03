@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Draft Post</h1>
        <x-form.draft-edit :tags="$tags" :post="$post"/>
    </div>
@endsection
@section('script')
    <script src="{{ asset('draftScript.js') }}"></script>
@endsection