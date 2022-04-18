@extends('admin.layouts.app')
@section('content')
    <admin-profile
            :admin="{{ json_encode($_admin) }}"
            :active-route="{{ json_encode($_activeRoute) }}"
    ></admin-profile>
@endsection
