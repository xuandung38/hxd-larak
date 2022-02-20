@extends('admin.layouts.app')
@section('content')
    <user-manager
            :user="{{ json_encode($_user) }}"
            :users="{{ $users->toJSon() }}"
    ></user-manager>
@endsection
