@extends('admin.layouts.app')
@section('content')
    <post-manager
            :posts="{{ json_encode($posts) }}"
            :admin="{{ json_encode($_admin) }}"
            :keyword="{{ json_encode($keyword) }}"
    ></post-manager>
@endsection
