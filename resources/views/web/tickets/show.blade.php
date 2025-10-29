@extends('web.layout')
@use('Illuminate\Support\Str')

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

            <div class=" row">
                <div class="col-md-6" style="text-align: center">
                    <a href="#editForm" type="submit" id="edit" class="btn text-light" style="width: auto;">{{ __('tickets.edit_request') }}</a>
                </div>
                {{-- <div class="col-6" style="text-align: center">
                    <a href="{{route('ticket.close',$ticket->id)}}" class="btn text-light" style="width: auto;">{{ __('tickets.close_request') }}</a>
                </div> --}}
                <div class="col-md-6 text-center">
                    @if ($ticket->user_id && $ticket->status === 'Closed')
                        <a href="{{ route('tickets.review', ['id' => $ticket->id]) }}"
                        class="btn btn-info"
                        style="width: auto; background: #17a2b8;">
                            {{ __('tickets.review_technician') }}
                        </a>
                    @endif
                </div>
            </div>
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
                    enctype="multipart/form-data" id="ticketForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="phone" id="full_phone" value="{{ old('phone', $ticket->phone) }}">

                    <div class="col-md-6">
                        <label for="printer_code" class="form-label">{{ __('tickets.printer_code') }} <span class="text-danger">*</span></label>
                        <input type="text" name="printer_code" class="form-control @error('printer_code') is-invalid @enderror" id="printer_code" maxlength="6"
                            minlength="6" pattern="[0-9]*" inputmode="numeric" value="{{ old('printer_code', $ticket->printer_code) }}" disabled>
                        @error('printer_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="text-danger small printer_code-error" style="margin-top: 0.25rem;"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="printer_id" class="form-label">{{ __('tickets.printer_model') }} <span class="text-danger">*</span></label>
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
                        <label for="problem_type_id" class="form-label">{{ __('tickets.problem_type') }} <span class="text-danger">*</span></label>
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
                        <label for="department" class="form-label">{{ __('tickets.department') }} <span class="text-danger">*</span></label>
                        <select name="department_id" id="department" class="form-select @error('department_id') is-invalid @enderror" disabled>
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
                        <div class="text-danger small department-error" style="margin-top: 0.25rem;"></div>
                    </div>

                    <hr />

                    <div class="col-md-6">
                        <label for="requester_name" class="form-label">{{ __('tickets.requester_name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="requester_name" class="form-control @error('requester_name') is-invalid @enderror" id="requester_name"
                            value="{{ old('requester_name', $ticket->requester_name) }}" disabled>
                        @error('requester_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="text-danger small requester_name-error" style="margin-top: 0.25rem;"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="phone_display" class="form-label">{{ __('tickets.phone_number') }} <span class="text-danger">*</span></label>
                        <div class="input-group" dir="ltr">
                            <span class="input-group-text">+966</span>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                id="phone_display" value="{{ old('phone', $ticket->phone) ? (Str::startsWith(old('phone', $ticket->phone), '+') ? substr(old('phone', $ticket->phone), 4) : substr(old('phone', $ticket->phone), 3)) : (isset($ticket->phone) ? (Str::startsWith($ticket->phone, '+') ? substr($ticket->phone, 4) : substr($ticket->phone, 3)) : '') }}" maxlength="9" minlength="9" pattern="[0-9]*" inputmode="numeric" disabled>
                        </div>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="text-danger small phone-error" style="margin-top: 0.25rem;"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">{{ __('tickets.email') }}</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            value="{{ old('email', $ticket->email) }}" disabled>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="text-danger small email-error" style="margin-top: 0.25rem;"></div>
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
    // Restrict printer_code to numbers only
    $('#printer_code').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Restrict phone_display to numbers only
    $('#phone_display').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $(document).ready(function () {
        $("#edit").click(function () {
            $("form input, form select, form textarea").attr('disabled',false);
            $('#save').show();

            // Add validation listeners when edit is clicked
            setupValidation();
        });
    });

    function setupValidation() {
        // Real-time validation for printer code
        $('#printer_code').off('blur keyup change input').on('blur keyup change input', function() {
            const codeValue = $(this).val();

            // Clear previous error
            $('.printer_code-error').text('');
            $(this).removeClass('is-invalid');

            let isValid = true;
            let errorMessage = '';

            if (!codeValue) {
                isValid = false;
                errorMessage = '{{ __('tickets.validation.printer_code_required') }}';
            } else if (!/^\d+$/.test(codeValue)) {
                isValid = false;
                errorMessage = '{{ __('tickets.validation.printer_code_numeric') }}';
            } else if (codeValue.length !== 6) {
                isValid = false;
                errorMessage = '{{ __('tickets.validation.printer_code_digits') }}';
            } else if (codeValue < '010601' || codeValue > '010699') {
                isValid = false;
                errorMessage = '{{ __('tickets.validation.printer_code_between') }}';
            }

            if (!isValid) {
                $(this).addClass('is-invalid');
                $('.printer_code-error').text(errorMessage);
            }
        });

        // Real-time validation for phone number
        $('#phone_display').off('input blur keyup change').on('input blur keyup change', function() {
            const phoneValue = $(this).val();

            // Clear previous error for phone
            $('.phone-error').text('');
            $(this).removeClass('is-invalid');

            // Validate phone number
            let isValid = true;
            let errorMessage = '';

            if (!phoneValue) {
                isValid = false;
                errorMessage = '{{ __('tickets.validation.phone_required') }}';
            } else if (!/^\d+$/.test(phoneValue)) {
                isValid = false;
                errorMessage = '{{ __('tickets.validation.phone_string') }}';
            } else if (phoneValue.length < 9) {
                isValid = false;
                errorMessage = '{{ __('tickets.validation.phone_regex') }}';
            } else if (phoneValue.length > 9) {
                // Prevent more than 9 digits
                $(this).val(phoneValue.substring(0, 9));
                return;
            }

            if (!isValid) {
                $(this).addClass('is-invalid');
                $('.phone-error').text(errorMessage);
            } else {
                // Update the hidden full phone field
                $('#full_phone').val('+966' + phoneValue);
            }
        });

        // Real-time validation for department
        $('#department').off('blur change').on('blur change', function() {
            const departmentValue = $(this).val();

            // Clear previous error
            $('.department-error').text('');
            $(this).removeClass('is-invalid');

            // Validate department selection
            if (!departmentValue) {
                $(this).addClass('is-invalid');
                $('.department-error').text('{{ __('tickets.validation.department_id_required') }}');
            }
        });

        // Real-time validation for requester name
        $('#requester_name').off('blur keyup change input').on('blur keyup change input', function() {
            const nameValue = $(this).val();

            // Clear previous error
            $('.requester_name-error').text('');
            $(this).removeClass('is-invalid');

            // Validate requester name
            if (!nameValue) {
                $(this).addClass('is-invalid');
                $('.requester_name-error').text('{{ __('tickets.validation.requester_name_required') }}');
            }
        });

        // Real-time validation for email
        $('#email').off('blur keyup change input').on('blur keyup change input', function() {
            const emailValue = $(this).val();

            // Clear previous error
            $('.email-error').text('');
            $(this).removeClass('is-invalid');

            // Validate email
            if (emailValue && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailValue)) {
                $(this).addClass('is-invalid');
                $('.email-error').text('{{ __('tickets.validation.email_email') }}');
            }
        });
    }

    // Handle form submission
    $('#ticketForm').on('submit', function(e) {
        // Trigger validation on all required fields
        $('#printer_code').trigger('blur');
        $('#phone_display').trigger('blur');
        $('#email').trigger('blur');
        $('#requester_name').trigger('blur');
        $('#department').trigger('blur');

        // Check if there are any validation errors
        if ($('.is-invalid').length > 0) {
            e.preventDefault();
            return false;
        }
    });
</script>
@if ($errors->any())
<script>
    $(document).ready(function () {
        $("form input, form select, form textarea").attr('disabled',false);
        $('#save').show();
        setupValidation();
    });
</script>
@endif
@endsection
