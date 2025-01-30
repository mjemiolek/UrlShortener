@extends('layouts.app')

@section('styles')

@endsection
@section('content')
    <div id="app" class="wrapper_url_shortener">
        <user-url-list :user="{{ json_encode(Auth::user()->id) }}"></user-url-list>
    </div>
@endsection