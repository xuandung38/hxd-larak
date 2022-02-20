@extends('admin.layouts.app')
@section('content')
    <role-manager
            :roles="{{ json_encode($_roles) }}"
            :permissions="{{ json_encode($_permissions) }}"
    ></role-manager>
@endsection
