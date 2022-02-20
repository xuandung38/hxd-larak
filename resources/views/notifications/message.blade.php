@extends('notifications.layouts.app')
@section('title') {{ $label }} @endsection
@section('content')
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="main">
        <h1>{{ $label }}</h1>
        <p>{{ $message }}</p>
        <a href="{{ route($route) }}">{{ $button }}</a>
    </div>
@endsection



