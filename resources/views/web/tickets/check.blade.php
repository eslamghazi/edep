    @extends('web.layout')

    @section('content')
        <div class="request form-data">
            <div class="contain-shadow">
                <div class="welcome">
                    <div class="row">
                        <img class="head-logo" src="{{ asset('assets/web/logo_web.svg') }}" alt="" />
                    </div>
                    <img class="logo find-p" src="{{ asset('assets/web/search 1.png') }}" alt="" />

                    <h1>
                        {{ __('tickets.find_ticket_title') }}
                    </h1>

                    <form action="{{ route('findTicketView') }}" method="Post">
                        @csrf
                        <div class="buttons last">
                            <div class="form-group">
                                <label for="ticket_code" class="form-label">{{ __('tickets.ticket_number') }}</label>
                                <input id="ticket_code" type="ticket_code"
                                    class="form-control @error('ticket_code') is-invalid @enderror" name="ticket_code"
                                    value="{{ old('ticket_code') }}" required autocomplete="ticket_code" autofocus>
                                @error('ticket_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn">
                                {{ __('tickets.search_button') }}
                            </button>

                        </div>

                    </form>

                </div>
                <div class="image">
                    <img class="image_full" src="{{ asset('assets/web/find-ticket.png') }}" alt="" />
                    <img class="image_mobile" src="{{ asset('assets/web/find-ticket-mobile.png') }}" alt="" />
                </div>
            </div>
        </div>
    @endsection
