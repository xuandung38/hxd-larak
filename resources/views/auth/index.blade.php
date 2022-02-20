@extends('auth.layouts.app')
@section('title') {{ $title }} @endsection
@section('content')
    <div class="wrapper wrapper-full-page">
        <div class="full-page login-page" style="background: url('{{ asset('images/bg.jpg') }}'); background-size: cover;">
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 col-lg-4 col-lg-offset-4">
                            <login-form
                                    :guard="{{ json_encode($guard) }}"
                                    :screen="{{ json_encode($screen) }}"
                                    :token="{{ json_encode($token ?? '') }}"
                                    @if(!empty($redirect))
                                    :redirect="{{ json_encode($redirect) }}"
                                    @endif
                            ></login-form>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class="container text-center">
                    <p class="copyright">
                        &copy;
                        <a href="{{ route('index') }}" target="_blank">{{ config('app.name') }}</a>
                    </p>
                </div>
            </footer>
        </div>
    </div>
@endsection
