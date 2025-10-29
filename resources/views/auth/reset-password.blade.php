@extends('web.layout')

@section('title')
    Reset Password
@endsection

@section('content')
    <div class="request form-data">
        <div class="contain-shadow">
            <div class="welcome">
                <div class="row">
                    <img class="head-logo" src="{{ asset('assets/web/logo_web.svg') }}" alt="" />
                </div>
                <img class="logo" src="{{ asset('assets/web/login.png') }}" alt="" />

                <h1>
                    {{ __('web.forgotPassword') }}
                </h1>

                @include('web.inc.messages')
                <form method="POST" action="{{ url('forgot-password') }}">
                    @csrf

                    <div class="buttons last">

                        <div class="form-group">
                            <label for="email" class="form-label">كلمة المرور :</label>
                            <input class="form-control" type="email" name="email" placeholder="Email" id="email"
                                type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <button type="submit" class="btn">{{ __('web.sumitBtn') }}</button>
                    </div>


                </form>
            </div>
            <div class="image">
                <img class="image_full" src="{{ asset('assets/web/reset-password.png') }}" alt="" />
                <img class="image_mobile" src="{{ asset('assets/web/reset-password-mobile.png') }}" alt="" />
            </div>
        </div>
    </div>
@endsection
