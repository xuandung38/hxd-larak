@extends('admin.layouts.app')
@section('content')
    <blog-category-manager
            :categories="{{ $categories->toJson() }}"
            :user="{{ $_user->toJson()}}"
            :keyword="{{ json_encode($keyword) }}"
    ></blog-category-manager>

@endsection
