@extends('admin.layouts.app')
@section('content')
    <post-manager
            :posts="{{ json_encode($posts) }}"
            :user="{{ json_encode($_user) }}"
            :keyword="{{ json_encode($keyword) }}"
    ></post-manager>
@endsection
