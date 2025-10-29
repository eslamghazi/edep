@extends('web.layout')

@section('content')
<div class="request form-data">
    <div class="contain-shadow">
        <div class="welcome">
            <div class="row">
                <img class="head-logo" src="{{ asset('assets/web/logo_web.svg') }}" alt="" />
            </div>

            <img class="logo" src="{{ asset('assets/web/success-icon.png') }}" alt="" />

            <h1>
                {!! __('tickets.success_title') !!}
            </h1>

            <div class="buttons last">
                <div class="form-group">
                    <label class="form-label">{{ __('tickets.ticket_code') }}</label>
                    <input type="text" class="form-control" value="{{$ticket->ticket_code}}" id="example" disabled>
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('tickets.creation_date') }}</label>
                    <input type="text" class="form-control"
                        value="{{ formatDate($ticket->created_at) }}"
                        disabled>
                </div>
                <a href="{{ route('tickets.show', $ticket->id) }}" class="btn">{{ __('tickets.check_request') }}</a>
            </div>

        </div>
        <div class="image">
            <img class="image_full" src="{{ asset('assets/web/ticket-id-page.png') }}" alt="" />
            <img class="image_mobile" src="{{ asset('assets/web/ticket-id-page-mobile.png') }}" alt="" />
        </div>
    </div>
</div>
@endsection
