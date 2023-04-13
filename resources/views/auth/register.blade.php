@extends('layouts.guest')

@section('content')
    <div class="auth-form-wrap">
        <div class="auth-form">
            <div class="auth-sec">
                <img src="{{ URL::asset('images/logo.png') }}" alt="">
                <div class="text1">
                    REGISTER
                </div>
                <form method="POST" action="{{ route('register') }}" enctype='multipart/form-data'>
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="mt-3">
                                <label for="email">Email Address</label>
                                <input id="email" placeholder="example@gmail.com" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mt-3">
                                <label for="name">Username</label>
                                <input id="name" placeholder="John Smith" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mt-3">
                                <label for="passowrd">New Password</label>
                                <input id="password" placeholder="*************" type="password"
                                    class="form-control @error('password') is-invalid @enderror" newpassword name="password"
                                    required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mt-3">
                                <label for="password-confirm">Confirm Password</label>
                                <input id="password-confirm" placeholder="*************" type="password"
                                    class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mt-3">
                                <label for="password-confirm">Profile Image</label>
                                <input id="image" placeholder="*************" type="file" class="form-control"
                                    name="image" accept="image/*" required>
                            </div>
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Register') }}
                        </button>
                        <div class="next"><a href="{{ route('login') }}">Login to existing account</a></div>
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
