@extends('admin.layouts.app')
@section('content')
    <setting-manager
            :setting="{{ json_encode($setting) }}"
            :admin="{{ json_encode($_admin) }}"
    ></setting-manager>

@endsection
