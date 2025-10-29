@extends('web.layout')


@section('title')
Verify Email
@endsection

@section('main')
<div class="alert alert-success">
    An verfication Email sent successfully, please check your inbox
</div>

<div id="contact" class="section">
    <!-- container -->
    <div class="container">

        <!-- row -->
        <div class="row">

            <!-- verify email form -->
            <div class="col-md-6 col-md-offset-3">
                <div class="contact-form">
                    <form action="{{url('/email/verification-notification')}}" method="post">
                        @csrf
                        <button type="submit" class="main-button icon-button ">Resend Email</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection