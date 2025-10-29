@extends('web.layout')

@section('content')
    <div class="request">
        <div class="contain-shadow">
            <div class="welcome">
                <div class="final_logo">
                    <img src="{{ asset('assets/web/logo_web.svg') }}" alt="" />
                </div>
                <h1>
                    {!! __('tickets.welcome_title') !!}
                </h1>

                <div class="buttons">
                    <a href="{{ route('tickets.create') }}" class="btn group">
                        <span class="add-text">
                            {{ __('tickets.create_new_request') }}
                        </span>

                        <span class="add-img">
                            <img src="{{ asset('assets/web/Add.svg') }}" alt="">
                        </span>
                    </a>
                    <a href="{{ route('findTicket') }}" class="btn group">
                        <span class="add-text">
                            {{ __('tickets.check_previous_request') }}
                        </span>

                        <span class="add-img ai-2">
                            <img src="{{ asset('assets/web/Group.svg') }}" alt="">
                        </span>
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="image">
                    <img class="image_full" src="{{ asset('assets/web/welcome-page.png') }}" alt="" />
                    <img class="image_mobile" src="{{ asset('assets/web/welcome-page-mobile.png') }}" alt="" />
                </div>
            </div>
        </div>
    </div>
@endsection
