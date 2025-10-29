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
                {{ __('tickets.create_title') }}
            </h4>
        </div>

        <div class="p-form">

            {{-- Display validation errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form">
                <form class="row g-5" method="Post" action="{{ route('tickets.store') }}" enctype="multipart/form-data" id="ticketForm">
                    @csrf
                    <input type="hidden" name="phone" id="full_phone" value="{{ old('phone') }}">
                    <div class="col-md-6">
                        <label for="printer_code" class="form-label text-sm">{{ __('tickets.printer_code') }} ({{ __('tickets.printer_code_range') }}) <span class="text-danger">*</span></label>
                        <input type="text" name="printer_code" class="form-control @error('printer_code') is-invalid @enderror"
                            id="printer_code" required maxlength="6" minlength="6" pattern="[0-9]*" inputmode="numeric" title="الرجاء إدخال رقم بين 010601 و 010699" value="{{ old('printer_code') }}"
                            placeholder="{{ __('tickets.printer_code_placeholder') }}" />
                        <div class="invalid-feedback printer_code-error"></div>
                    </div>
                    <div class="col-md-6">
                        <label for="printer_id" class="form-label">{{ __('tickets.printer_model') }} <span class="text-danger">*</span></label>
                        <select name="printer_id" id="printer_id" class="form-select @error('printer_id') is-invalid @enderror">
                            @foreach ($printers as $printer)
                            <option value="{{ $printer->id }}" {{ old('printer_id') == $printer->id ? 'selected' : '' }}>
                                {{ $printer->localized_name }}
                            </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback printer_id-error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="problem_type_id" class="form-label">{{ __('tickets.problem_type') }} <span class="text-danger">*</span></label>
                        <select name="problem_type_id" id="problem_type_id" class="form-select @error('problem_type_id') is-invalid @enderror" required>
                            @foreach ($problemTypes as $problemType)
                            <option value="{{ $problemType->id }}" {{ old('problem_type_id') == $problemType->id ? 'selected' : '' }}>
                                {{ $problemType->localized_name }}
                            </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback problem_type_id-error"></div>
                    </div>
                    <div class="col-md-6">
                        <label for="image" class="form-label">{{ __('tickets.upload_image') }}</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="image" accept="image/*"/>
                        <div class="invalid-feedback image-error"></div>
                    </div>
                    <div class="col-md-12">
                        <label for="description" class="form-label">{{ __('tickets.description') }}</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                            rows="4">{{ old('description') }}</textarea>
                        <div class="invalid-feedback description-error"></div>
                    </div>

                    <hr />
                    <div class="col-md-6">
                        <label for="organization_name" class="form-label">{{ __('tickets.organization_name') }}</label>
                        <h5 style="font-weight: bold">{{ __('tickets.organization_value') }}</h5>
                    </div>

                    <div class="col-md-6">
                        <label for="department_id" class="form-label">{{ __('tickets.department') }} <span class="text-danger">*</span></label>
                        <select name="department_id" id="department_id" class="form-select @error('department_id') is-invalid @enderror" required>
                            <option value="" selected>{{ __('tickets.select_department') }}</option>
                            @foreach ($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->localized_name }}
                            </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback department_id-error"></div>
                    </div>


                    <hr />
                    <div class="col-md-6">
                        <label for="requester_name" class="form-label">{{ __('tickets.requester_name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="requester_name" class="form-control @error('requester_name') is-invalid @enderror"
                            id="requester_name" required value="{{ old('requester_name') }}" />
                        <div class="invalid-feedback requester_name-error"></div>
                    </div>
                    <div class="col-md-6">
                        <label for="phone_display" class="form-label">{{ __('tickets.phone_number') }} <span class="text-danger">*</span></label>
                        <div class="input-group" dir="ltr">
                            <span class="input-group-text">+966</span>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                id="phone_display" value="{{ old('phone') ? substr(old('phone'), 3) : '' }}" maxlength="9" minlength="9" pattern="[0-9]*" inputmode="numeric" />
                        </div>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="text-danger small phone-error" style="margin-top: 0.25rem;"></div>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">{{ __('tickets.email') }}</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" value="{{ old('email') }}" />
                        <div class="invalid-feedback email-error"></div>
                    </div>


                    <div class="col-12" style="text-align: center">
                        <button type="submit" class="btn text-light">{{ __('tickets.submit_button') }}</button>
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

    // Real-time validation
    $('#ticketForm input, #ticketForm select, #ticketForm textarea').on('blur keyup change', function() {
        const field = $(this);
        const fieldName = field.attr('name');
        const fieldValue = field.val();

        // Clear previous error for this field
        $(`.${fieldName}-error`).text('');
        field.removeClass('is-invalid');

        // Skip validation for image field only
        if (fieldName === 'image') return;

        // Validate field
        let isValid = true;
        let errorMessage = '';

        switch(fieldName) {
            case 'printer_code':
                if (!fieldValue) {
                    isValid = false;
                    errorMessage = '{{ __('tickets.validation.printer_code_required') }}';
                } else if (!/^\d+$/.test(fieldValue)) {
                    isValid = false;
                    errorMessage = '{{ __('tickets.validation.printer_code_numeric') }}';
                } else if (fieldValue.length !== 6) {
                    isValid = false;
                    errorMessage = '{{ __('tickets.validation.printer_code_digits') }}';
                } else if (fieldValue < '010601' || fieldValue > '010699') {
                    isValid = false;
                    errorMessage = '{{ __('tickets.validation.printer_code_between') }}';
                }
                break;
            case 'printer_id':
                if (!fieldValue) {
                    isValid = false;
                    errorMessage = '{{ __('tickets.validation.printer_id_required') }}';
                } else if (!/^\d+$/.test(fieldValue)) {
                    isValid = false;
                    errorMessage = '{{ __('tickets.validation.printer_id_numeric') }}';
                }
                break;
            case 'problem_type_id':
                if (!fieldValue) {
                    isValid = false;
                    errorMessage = '{{ __('tickets.validation.problem_type_id_required') }}';
                } else if (!/^\d+$/.test(fieldValue)) {
                    isValid = false;
                    errorMessage = '{{ __('tickets.validation.problem_type_id_numeric') }}';
                }
                break;
            case 'department_id':
                if (!fieldValue) {
                    isValid = false;
                    errorMessage = '{{ __('tickets.validation.department_id_required') }}';
                } else if (!/^\d+$/.test(fieldValue)) {
                    isValid = false;
                    errorMessage = '{{ __('tickets.validation.department_id_numeric') }}';
                }
                break;
            case 'requester_name':
                if (!fieldValue) {
                    isValid = false;
                    errorMessage = '{{ __('tickets.validation.requester_name_required') }}';
                }
                break;
            case 'email':
                if (fieldValue && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(fieldValue)) {
                    isValid = false;
                    errorMessage = '{{ __('tickets.validation.email_email') }}';
                }
                break;
            case 'description':
                // Description is optional, so no validation needed
                break;
        }

        if (!isValid) {
            field.addClass('is-invalid');
            $(`.${fieldName}-error`).text(errorMessage);
        }
    });

    // Handle phone number input - show feedback immediately
    $('#phone_display').on('input blur keyup change', function() {
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
            $('#full_phone').val('966' + phoneValue);
        }
    });

    // Handle form submission
    $('#ticketForm').on('submit', function(e) {
        // Trigger validation on phone field
        $('#phone_display').trigger('blur');

        // Trigger validation on email field
        $('#email').trigger('blur');

        // Check if there are any validation errors
        if ($('.is-invalid').length > 0) {
            e.preventDefault();
            return false;
        }
    });

    $('#city').on('change', function() {
        let city = $(this).val();
        if (city) {
            let link = '{{ url('/buildingsByCity') }}';
            $.ajax({
                url: link + '/' + city,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#building').empty();
                    $('#building').append('<option value="">{{ __('اختار المبني') }}</option>');
                    $.each(data, function(key, value) {
                        $('#building').append('<option value="' + key + '">' + value +
                            '</option>');
                    });
                }
            });
        }
    });
</script>
@endsection
