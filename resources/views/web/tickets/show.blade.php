@extends('web.layout')

@section('content')
<div class="request">

    <div class="new-request">
        <div class="header">
            <div class="logo">
                <img src="{{ asset('assets/web/logo_web.svg') }}" alt="" />
            </div>
            <h4 class="d-flex">
                <span style="{{ app()->getLocale() == 'ar' ? 'margin-left: 20px;' : 'margin-right: 20px;' }}">
                    <img src="{{ asset('assets/web/Add.svg') }}" alt="">
                </span>
                {{ __('tickets.maintenance_request') }}
            </h4>
        </div>
        <div class="p-form">

            @if($ticket->status != 'closed')
            <div class=" row">
                <div class="col-md-6" style="text-align: center">
                    <a href="#editForm" type="submit" id="edit" class="btn text-light" style="width: auto;">{{ __('tickets.edit_request') }}</a>
                </div>
                {{-- <div class="col-6" style="text-align: center">
                    <a href="{{route('ticket.close',$ticket->id)}}" class="btn text-light" style="width: auto;">{{ __('tickets.close_request') }}</a>
                </div> --}}
                <div class="col-md-6" style="text-align: center">
                    <a href="{{ route('tickets.review') }}?id={{ $ticket->id }}" class="btn btn-info" style="width: auto; background: #17a2b8">{{ __('tickets.review_technician') }}</a>
                </div>
            </div>
            @endif
            <div class="form">

                <div class="row g-5">
                    <div class="col-md-6">
                        <label for="num" class="form-label">{{ __('tickets.ticket_number') }} </label>
                        <input type="text" style="text-align: center;" name="ticket_code" class="form-control" id="num"
                            required maxlength="6" minlength="6" value="{{ $ticket->ticket_code }}" disabled>
                    </div>
                    <div class="col-md-6">
                        <label for="num" class="form-label">{{ __('tickets.ticket_status') }}</label>
                        <input type="text" style="text-align: center;" name="status" class="form-control" id="num"
                        required maxlength="6" minlength="6"
                        value="{{ $ticket->status == 'Closed' ? __('tickets.status_closed') :
                                ($ticket->status == 'InProgress' ? __('tickets.status_in_progress') :
                                ($ticket->status == 'waiting' ? __('tickets.status_waiting') :
                                ($ticket->status == 'close_request' ? __('tickets.status_close_request') : __('tickets.status_new')))) }}"
                        readonly disabled>


                    </div>

                    <div class="col-md-6">
                        <label for="num" class="form-label">{{ __('tickets.creation_date') }}</label>
                        <input type="text" style="text-align: center;" name="created" class="form-control"
                            value="{{ formatDate($ticket->created_at) }}"
                            disabled>
                    </div>
                    @if($ticket->user_id)
                    <div class="col-md-6">
                        <label for="num" class="form-label">{{ __('tickets.assigned_technician') }}</label>
                        <input type="text" style="text-align: center;" name="user" class="form-control" id="num"
                            value="{{$ticket->user->name}}" readonly disabled>
                    </div>
                    @endif
                </div>
            </div>
            @if($ticket->image)
            <div class="form">

                <div class="row">
                    <div class="img" style=" display: flex ; width: 100%; flex-direction: column;text-align: center;">

                    <h2 for="num" class="form-label">{{ __('tickets.problem_image') }}</h2>
                        <div>
                            <img style="width: 200px;height: 200px" src="{{$ticket->image}}">
                        </div>
                    </div>

                </div>
            </div>
            @endif
            <div class="form" id="editForm">
                <form class="row g-5" method="POST" action="{{ route('tickets.update', $ticket->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6">
                        <label for="num" class="form-label">{{ __('tickets.printer_code') }}</label>
                        <input type="text" name="printer_code" class="form-control @error('printer_code') is-invalid @enderror" id="num" required maxlength="6"
                            minlength="6" value="{{ old('printer_code', $ticket->printer_code) }}" disabled>
                        @error('printer_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="printer_id" class="form-label">{{ __('tickets.printer_model') }}</label>
                        <select name="printer_id" id="printer_id" class="form-select @error('printer_id') is-invalid @enderror" disabled>
                            @foreach($printers as $printer)
                            <option value="{{ $printer->id }}" {{ old('printer_id', $ticket->printer_id) == $printer->id ? 'selected' : '' }}>{{ $printer->localized_name }}</option>
                            @endforeach
                        </select>
                        @error('printer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="problem_type_id" class="form-label">{{ __('tickets.problem_type') }}</label>
                        <select name="problem_type_id" id="problem_type_id" class="form-select @error('problem_type_id') is-invalid @enderror" required disabled>
                            @foreach($problemTypes as $problemType)
                            <option value="{{ $problemType->id }}" {{ old('problem_type_id', $ticket->problem_type_id) == $problemType->id ?
                                'selected' : '' }}>{{ $problemType->localized_name }}</option>
                            @endforeach
                        </select>
                        @error('problem_type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="col-md-12">
                        <label for="description" class="form-label">{{ __('tickets.description') }}</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4"
                            disabled>{{ old('description', $ticket->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr />

                    {{-- <div class="col-md-6">
                        <label for="city" class="form-label">{{ __('tickets.city') }}</label>
                        <select name="city_id" id="city" class="form-select" required disabled>
                            <option value="" selected>{{ __('tickets.select_city') }}</option>
                            @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ $ticket->city_id == $city->id ? 'selected' : '' }}>{{
                                $city->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="building" class="form-label">{{ __('tickets.building') }}</label>
                        <select name="building_id" id="building" class="form-select" required disabled>
                            <option value="" selected>{{ __('tickets.select_building') }}</option>
                            @foreach($buildings as $building)
                            <option value="{{ $building->id }}" {{ $ticket->building_id == $building->id ? 'selected' :
                                ''
                                }}>{{ $building->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}

                    <div class="col-md-6">
                        <label for="department" class="form-label">{{ __('tickets.department') }}</label>
                        <select name="department_id" id="department" class="form-select @error('department_id') is-invalid @enderror" required disabled>
                            <option value="" selected>{{ __('tickets.select_department') }}</option>
                            @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id', $ticket->department_id) == $department->id ? 'selected' : '' }}>
                                {{ $department->localized_name }}
                            </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr />

                    <div class="col-md-6">
                        <label for="requester_name" class="form-label">{{ __('tickets.requester_name') }}</label>
                        <input type="text" name="requester_name" class="form-control @error('requester_name') is-invalid @enderror" id="requester_name" required
                            value="{{ old('requester_name', $ticket->requester_name) }}" disabled>
                        @error('requester_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label">{{ __('tickets.phone_number') }}</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" required
                            value="{{ old('phone', $ticket->phone) }}" disabled>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">{{ __('tickets.email') }}</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            value="{{ old('email', $ticket->email) }}" disabled>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @if($ticket->image)
                    <div class="form">

                        <div class="row">
                            <div class="img"
                                style=" display: flex ; width: 100%; flex-direction: column;text-align: center;">

                                <h2>{{ __('tickets.maintenance_report') }}</h2>
                                <div>
                                    <textarea name="report" id="report" class="form-control" rows="4"
                                        readonly>{{ $ticket->report }}</textarea>

                                </div>
                            </div>

                        </div>
                    </div>
                    @endif
                    <div class="col-12" style="text-align: center">
                        <button type="submit" id="save" class="btn" style="display:none;">{{ __('tickets.save_changes') }}</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@section('script')
<script>
        $(document).ready(function () {
            $("#edit").click(function () {
                $("form input, form select, form textarea").attr('disabled',false);
                $('#save').show();
            });
        });
</script>
@if ($errors->any())
<script>
    $(document).ready(function () {
        $("form input, form select, form textarea").attr('disabled',false);
        $('#save').show();
    });
</script>
@endif
@endsection
