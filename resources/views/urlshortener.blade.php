@extends('layouts.app')

@section('styles')

@endsection
@section('content')
    <div id="app" class="wrapper_url_shortener">
        <url-shortener :user="{{ json_encode(Auth::user()) }}"></url-shortener>
    </div>
@endsection