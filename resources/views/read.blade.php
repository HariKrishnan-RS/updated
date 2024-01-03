@extends('layouts.app')

@section('content')
    <div class="post">
        <h1 class="post-title">{{$post->title}}</h1>
        <img src="{{ asset('images/post-img.jpg') }}" alt="Post Image" class="post-image">

        <x-common.session-alert key="addedComment" type="success" />

        <div class="author">
            <img src="{{ asset('images/user.png') }}" alt="Author Image" class="author-image">
            <span class="author-name">{{$user_name}}</span>
        </div>

        <p class="full-description">
            {{$post->full_description}}
        </p>

        <x-common.comment-lists :comments="$comments"/>

        <x-form.create-comment :post="$post"/>

        <div>
            <!-- Your Blade file content -->
{{--            <form class="form" method="POST" action="{{ route('post.show',['id'=>$post->id]) }}">--}}
{{--                @csrf--}}
{{--                --}}{{--            <input type="hidden" name="post_id" value="{{ $post->id }}">--}}
{{--                <fieldset class="rating">--}}
{{--                    <input type="radio" id="star1" name="rating" value="5">--}}
{{--                    <label for="star1" title="1">&#9733;</label>--}}
{{--                    <input type="radio" id="star2" name="rating" value="4">--}}
{{--                    <label for="star2" title="2">&#9733;</label>--}}
{{--                    <input type="radio" id="star3" name="rating" value="3">--}}
{{--                    <label for="star3" title="3">&#9733;</label>--}}
{{--                    <input type="radio" id="star4" name="rating" value="2">--}}
{{--                    <label for="star4" title="4">&#9733;</label>--}}
{{--                    <input type="radio" id="star5" name="rating" value="1">--}}
{{--                    <label for="star5" title="5">&#9733;</label>--}}
{{--                </fieldset>--}}
{{--                <div class="rate-div">--}}
{{--                    <button class="rate-btn" type="submit" name="rate">Rate post</button>--}}
{{--                </div>--}}


{{--            </form>--}}
            <!-- Other content -->






{{--            <div>--}}
{{--                <!-- Progress Bar 1 -->--}}
{{--                <progress max="100" value="50"></progress>--}}
{{--                <br><br>--}}

{{--                <!-- Progress Bar 2 -->--}}
{{--                <progress max="100" value="70"></progress>--}}
{{--                <br><br>--}}

{{--                <!-- Progress Bar 3 -->--}}
{{--                <progress max="100" value="30"></progress>--}}
{{--                <br><br>--}}

{{--                <!-- Progress Bar 4 -->--}}
{{--                <progress max="100" value="85"></progress>--}}
{{--                <br><br>--}}

{{--                <!-- Progress Bar 5 -->--}}
{{--                <progress max="100" value="40"></progress>--}}
{{--                <br><br>--}}

{{--                <!-- Your other body content -->--}}
{{--            </div>--}}

            @auth
                @if(auth()->user()->role === 'admin' && !$post->approved)
                    <form method="POST" action="{{ route('post.update',['id'=>$post->id]) }}">
                        @csrf
                        <button class="btn btn-success mt-1" name="approve" type="submit">Approve</button>
                    </form>
                @endif
                @if(auth()->user()->role === 'admin' && $post->approved)
                    <form method="POST" action="{{ route('post.delete',['id'=>$post->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger mt-1"  type="submit" name="delete">Delete</button>
                    </form>
                @endif

                @if(auth()->user()->role === 'editor')
                    <form method="GET" action="{{ route('editPost.show',['id'=>$post->id]) }}">
                        @csrf
                        <button class="btn btn-warning mt-1" name="edit" type="submit">Edit</button>
                    </form>
                @endif
            @endauth

        </div>
    </div>
@endsection

@section('style')
    <link href="{{ asset('readPage.css') }}" rel="stylesheet">
@endsection
