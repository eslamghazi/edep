@extends('web.layout')

@section('content')
    <div class="request form-data">
        <div class="contain-shadow">
            <div class="welcome">
                <div class="row">
                    <img class="head-logo" src="{{ asset('assets/web/logo_web.svg') }}" alt="" />
                </div>
                <img class="logo" src="{{ asset('assets/web/login.png') }}" alt="" />

                <h1>
                    تسجيل الدخول
                </h1>

                <form method="POST" action="{{ route('login') }}">
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
                        <div class="form-group">
                            <label for="password" class="form-label">كلمة المرور :</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn">
                            تسجيل الدخول
                        </button>
                        @if (Route::has('password.request'))
                            <a class="text-dark" href="{{ route('password.request') }}">
                                إسترجاع كلمة المرور ؟
                            </a>
                        @endif
                    </div>

                </form>

            </div>
            <div class="image">
                <img class="image_full" src="{{ asset('assets/web/login-page.png') }}" alt="" />
                <img class="image_mobile" src="{{ asset('assets/web/login-page-mobile.png') }}" alt="" />
            </div>
        </div>
    </div>
@endsection
