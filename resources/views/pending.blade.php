
@extends('layouts.app')

@section('content')

    <x-common.blog-navbar />

    <div class="pt-5 mb-3" ></div>

    <x-common.session-alert key="approve" type="success" />

    <x-common.not-aproved-post-grid :posts="$posts"/>
    <button type="submit" class="btn btn-secondary m-5" name="back" id="backbtn">back</button>
@endsection

@section('style')
    <link href="{{ asset('style.css') }}" rel="stylesheet">
@endsection


@section('script')
    <script src="{{ asset('pendingScript.js') }}"></script>
@endsection