@extends('admin.layouts.'.$layout)
@section('content')
    <file-manager
            :has-editor="{{ json_encode($hasEditor) }}"
            :has-selector="{{ json_encode($hasSelector) }}"
    ></file-manager>
@endsection
