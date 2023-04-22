@extends('layouts.guest')

@section('content')
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="auth-form-wrap">
        <div class="auth-form">
            <div class="auth-sec">
                <img src="{{ URL::asset('images/logo.png') }}" alt="">
                <div class="text1">
                    LOGIN
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mt-3">
                        <label for="email">Email Address</label>
                        <input id="email" placeholder="example@gmail.com" type="email"
                            class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label for="password">Password</label>
                        <input id="password" placeholder="*************" type="password"
                            class="form-control @error('password') is-invalid @enderror" newpassword name="password"
                            required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Login') }}
                        </button>
                        <div class="next"><a href="{{ route('register') }}">Create new account</a></div>
                    </div>
                </form>
            </div>
            <div class="image-sec">
                <div class="title">Travel Book</div>
                <div class="subtitle">Travel with passion. You can share your memories and have fun at the same time.</div>
                <img src="{{ URL::asset('images/part1.png') }}" alt="">
            </div>
        </div>
    </div>
@endsection
