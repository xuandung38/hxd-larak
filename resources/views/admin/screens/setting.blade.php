@extends('admin.layouts.app')
@section('content')
    <setting-manager
            :setting="{{ json_encode($setting) }}"
            :user="{{ json_encode($_user) }}"
    ></setting-manager>

@endsection
