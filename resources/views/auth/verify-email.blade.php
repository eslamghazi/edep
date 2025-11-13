@extends('web.layout')

@section('title')
تأكيد البريد الإلكتروني
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
                تم إرسال رسالة التحقق بنجاح، يرجى مراجعة البريد الوارد
            </h1>

            <form action="{{ url('/email/verification-notification') }}" method="post">
                @csrf
                <div class="buttons last">
                    <button type="submit" class="btn">إعادة إرسال البريد</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection