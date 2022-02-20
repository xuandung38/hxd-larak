@extends('admin.layouts.app')
@section('content')
    <admin-manager
            :user="{{ json_encode($_user) }}"
            :admin-roles="{{ json_encode($_availableRoles) }}"
            :admins="{{ json_encode($admins) }}"
    ></admin-manager>
@endsection
