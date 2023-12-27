
@extends('layouts.app')

@section('content')

    <x-common.blog-navbar />

    <div class="pt-5 mb-3" ></div>

    <x-common.session-alert key="approve" type="success" />

    <x-common.not-aproved-post-grid :posts="$posts"/>

@endsection

@section('style')
    <link href="{{ asset('style.css') }}" rel="stylesheet">
@endsection


