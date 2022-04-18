@extends('admin.layouts.app')
@section('content')
    <user-manager
            :admin="{{ json_encode($_admin) }}"
            :users="{{ $users->toJSon() }}"
    ></user-manager>
@endsection
