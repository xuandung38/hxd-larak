@extends('errors.layouts.app')
@section('title')Page not found @endsection
@section('content')
    <div class="page-404 container-fluid">
        <div class="row">
            <div class="col-md-6 col-12 error-404">
                <div class="err">
                    <div class="e-404">
                        404
                    </div>
                    <div class="line"></div>
                    <p class="text-404">
                        Sorry, the page you are looking for could not be found.</p>
                    <a href="{{ route('index') }}">
                        <button class="btn-404">
                            Go Home
                        </button>
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-12 img">
                <img src="{{ asset('images/404.svg') }}" alt="">
            </div>
        </div>
    </div>
@endsection



