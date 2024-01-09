@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="alert alert-info no-draft-message" role="alert">
            You have no draft.
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('draftScript.js') }}"></script>
@endsection