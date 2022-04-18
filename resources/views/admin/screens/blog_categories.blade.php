@extends('admin.layouts.app')
@section('content')
    <blog-category-manager
            :categories="{{ $categories->toJson() }}"
            :admin="{{ $_admin->toJson()}}"
            :keyword="{{ json_encode($keyword) }}"
    ></blog-category-manager>

@endsection
