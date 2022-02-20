@extends('admin.layouts.app')
@section('content')
    <user-profile
            :user="{{ json_encode($_user) }}"
            :active-route="{{ json_encode($_activeRoute) }}"
    ></user-profile>
@endsection