@extends('web.layout')

@section('content')
    <div class="request form-data">
        <div class="contain-shadow">
            <div class="welcome">
                <div class="row">
                    <img class="head-logo" src="{{ asset('assets/web/logo_web.svg') }}" alt="" />
                </div>
                <img class="logo reset-p" src="{{ asset('assets/web/forget-pass.png') }}" alt="" />

                <h1>
                    استعادة كلمة المرور

                </h1>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="buttons last">
                        <div class="form-group">
                            <label for="email" class="form-label">البريد الألكترونى:</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn">
                            استعادة كلمة المرور
                        </button>

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
