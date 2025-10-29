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
                <form class="row g-5" method="Post" action="{{ route('tickets.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-6">
                        <label for="selector" class="form-label text-sm">{{ __('tickets.printer_code') }} ({{ __('tickets.printer_code_range') }}) <span class="text-danger">*</span></label>
                        <input type="text" name="printer_code" class="form-control @error('printer_code') is-invalid @enderror"
                            id="num" required maxlength="6" minlength="6" pattern="^0106(0[1-9]|[1-9][0-9])$" inputmode="numeric" title="الرجاء إدخال رقم بين 010601 و 010699" value="{{ old('printer_code') }}"
                            placeholder="{{ __('tickets.printer_code_placeholder') }}" />
                        @error('printer_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="selector" class="form-label">{{ __('tickets.printer_model') }} <span class="text-danger">*</span></label>
                        <select name="printer_id" id="" class="form-select @error('printer_id') is-invalid @enderror">
                            @foreach ($printers as $printer)
                            <option value="{{ $printer->id }}" {{ old('printer_id') == $printer->id ? 'selected' : '' }}>
                                {{ $printer->localized_name }}
                            </option>
                            @endforeach
                        </select>
                        @error('printer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="selector" class="form-label">{{ __('tickets.problem_type') }} <span class="text-danger">*</span></label>
                        <select name="problem_type_id" id="problem_type_id" class="form-select @error('problem_type_id') is-invalid @enderror" required>
                            @foreach ($problemTypes as $problemType)
                            <option value="{{ $problemType->id }}" {{ old('problem_type_id') == $problemType->id ? 'selected' : '' }}>
                                {{ $problemType->localized_name }}
                            </option>
                            @endforeach
                        </select>
                        @error('problem_type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="file" class="form-label">{{ __('tickets.upload_image') }}</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="file" accept="image/*"/>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="description" class="form-label">{{ __('tickets.description') }}</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                            rows="4">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr />
                    <div class="col-md-6">
                        <label for="num" class="form-label">{{ __('tickets.organization_name') }}</label>
                        <h5 style="font-weight: bold">{{ __('tickets.organization_value') }}</h5>
                    </div>
                    <!-- <div class="col-md-6">
                        <label for="selector" class="form-label">المدينة <span class="text-danger">*</span></label>
                        <select name="city_id" id="city" class="form-select @error('city_id') is-invalid @enderror" required>
                            <option value="" selected>اختار المدينه</option>
                            @foreach ($cities as $city)
                            <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('city_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> -->

                    <!-- <div class="col-md-6 mt-2">
                        <label for="selector" class="form-label">نوع المبني <span class="text-danger">*</span></label>

                        <div class="form-check">
                            <input class="form-check-input @error('building_type') is-invalid @enderror" name="building_type"
                                value="male" type="radio" {{ old('building_type', 'male') == 'male' ? 'checked' : '' }} />

                            <label class="form-check-label"><b>رجال</b> (تتم الصيانة خلال وقت الدوام الرسمي) </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input @error('building_type') is-invalid @enderror" name="building_type"
                                value="female" type="radio" {{ old('building_type') == 'female' ? 'checked' : '' }} />
                            <label class="form-check-label"> <b>نساء</b> (تتم الصيانة خارج وقت الدوام الرسمي) </label>
                        </div>
                        @error('building_type')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="selector" class="form-label">المبني  <span class="text-danger">*</span></label>
                        <select name="building_id" id="building" class="form-select @error('building_id') is-invalid @enderror" required>
                            <option value="" selected>اختار المبني</option>
                        </select>
                        @error('building_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> -->

                    <div class="col-md-6">
                        <label for="selector" class="form-label">{{ __('tickets.department') }} <span class="text-danger">*</span></label>
                        <select name="department_id" id="department" class="form-select @error('department_id') is-invalid @enderror" required>
                            <option value="" selected>{{ __('tickets.select_department') }}</option>
                            @foreach ($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
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
                        <label for="selector" class="form-label">{{ __('tickets.requester_name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="requester_name" class="form-control @error('requester_name') is-invalid @enderror"
                            id="num" required value="{{ old('requester_name') }}" />
                        @error('requester_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="selector" class="form-label">{{ __('tickets.phone_number') }} <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                            id="num" required value="{{ old('phone') }}" />
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="selector" class="form-label">{{ __('tickets.email') }}</label>
                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
                            id="num" value="{{ old('email') }}" />
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
