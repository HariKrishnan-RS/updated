@extends('layouts.app')

@section('content')
  <x-common.blog-navbar />

  <x-common.blog-head-image />
@if(isset($role))
  <x-common.welcome-message :role="$role" :name="$name" :id="$id"/>
@else
  <x-common.welcome-message />
@endif


  <x-common.session-alert key="draftMsg" type="danger" />
  <x-common.session-alert key="login_message" type="success" />
  <x-common.session-alert key="logout_message" type="success" />
  <x-common.session-alert key="posted" type="success" />

  <x-form.tag-search :tags="$tags" />

  <x-common.posts-grid :posts="$posts" />

  @auth
  <x-common.add-post-button :userRole="auth()->user()->role" />

  <x-common.pending-post-button :userRole="auth()->user()->role" />

  <x-form.logout-button />
  @endauth

  @if(isset($role))
  @if($role)
    <x-common.add-post-button :userRole="$role" :id="$id" />

    <x-common.pending-post-button :userRole="$role" :id="$id" />

    <x-form.logout-button />
  @endif
  @endif






@endsection

@section('style')
  <link href="{{ asset('style.css') }}" rel="stylesheet">
@endsection

@section('script')
  <script src="{{ asset('script.js') }}"></script>
@endsection
