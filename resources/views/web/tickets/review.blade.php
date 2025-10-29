@extends('web.layout')

@section('content')
<div class="request">
    <div class="new-request">
        <div class="header">
            <div class="logo">
                <img src="{{ asset('assets/web/logo_web.svg') }}" alt="" />
            </div>
            <h4 class="d-flex align-items-center">
            <span style="{{ app()->getLocale() == 'ar' ? 'margin-left: 20px;' : 'margin-right: 20px;' }}">
                <img src="{{ asset('assets/web/Add.svg') }}" alt="" style="width: 24px; height: 24px;">
            </span>
                {{ __('tickets.review_technician') }}
            </h4>
        </div>

        <div class="p-form">
            {{-- Check if ticket can be reviewed (has technician and is closed) --}}
            @php
                $canReview = $ticket->user_id && $ticket->status === 'Closed';
            @endphp

            @if(!$canReview)
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ __('tickets.review_not_available') }}
                    <ul class="mb-0 mt-2">
                        @if(!$ticket->user_id)
                            <li>{{ __('tickets.review_requires_technician') }}</li>
                        @endif
                        @if($ticket->status !== 'closed')
                            <li>{{ __('tickets.review_requires_closed_ticket') }}</li>
                        @endif
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-primary btn-lg px-5">
                        <i class="fas fa-arrow-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>
                        {{ __('tickets.return_to_details') }}
                    </a>
                </div>
            @else
                {{-- Display validation errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-exclamation-triangle"></i> {{ __('tickets.validation_errors') }}</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Success Message -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="form">
                    {{-- Ticket Information Card --}}
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-info-circle"></i> {{ __('tickets.ticket_info') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-ticket-alt text-primary {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>
                                        <strong>{{ __('tickets.ticket_number') }}:</strong>
                                        <span class="{{ app()->getLocale() == 'ar' ? 'me-2' : 'ms-2' }} badge bg-primary">{{ $ticket->ticket_code }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-user-tie text-success {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>
                                        <strong>{{ __('tickets.assigned_technician') }}:</strong>
                                        <span class="{{ app()->getLocale() == 'ar' ? 'me-2' : 'ms-2' }}">{{ $technician->name ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-building text-info {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>
                                        <strong>{{ __('tickets.department') }}:</strong>
                                        <span class="{{ app()->getLocale() == 'ar' ? 'me-2' : 'ms-2' }}">{{ $ticket->department->localized_name ?? '-' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-print text-secondary {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>
                                        <strong>{{ __('tickets.printer_model') }}:</strong>
                                        <span class="{{ app()->getLocale() == 'ar' ? 'me-2' : 'ms-2' }}">{{ $ticket->printer->name ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

        {{-- Review Card --}}
        <div class="card shadow-sm">
            <div class="card-header {{ $existingReview ? 'bg-success text-white' : 'bg-primary text-white' }}">
                <h5 class="mb-0">
                    <i class="fas {{ $existingReview ? 'fa-check-circle' : 'fa-star' }}"></i>
                    {{ $existingReview ? __('tickets.review_submitted') : __('tickets.maintenance_report') }}
                </h5>
            </div>
            <div class="card-body">
                @if($existingReview)
                    <!-- Display existing review -->
                    <div class="alert alert-success border-success" style="background-color: #d1e7dd;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle fa-2x text-success {{ app()->getLocale() == 'ar' ? 'ms-3' : 'me-3' }}"></i>
                            <div>
                                <h6 class="alert-heading mb-1">{{ __('tickets.review_already_submitted') }}</h6>
                                <small class="text-muted">{{ __('tickets.thank_you_feedback') }}</small>
                            </div>
                        </div>
                    </div>
                    {{-- Rating Summary --}}
                    @php
                        $avgRating = (($existingReview->professionalism ?? 0) +
                                     ($existingReview->response_time ?? 0) +
                                     ($existingReview->quality_of_work ?? 0) +
                                     ($existingReview->communication ?? 0) +
                                     ($existingReview->overall_satisfaction ?? 0)) / 5;
                    @endphp
                    <div class="text-center mb-4 p-4 bg-light rounded">
                        <h3 class="mb-2 text-primary">{{ number_format($avgRating, 1) }}/5</h3>
                        <div class="mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= round($avgRating) ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                        </div>
                        <small class="text-muted">{{ __('tickets.average_rating') }}</small>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="width: 50%"><i class="fas fa-clipboard-list {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>{{ __('tickets.criteria') }}</th>
                                    <th style="width: 30%" class="text-center"><i class="fas fa-star {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>{{ __('tickets.rating') }}</th>
                                    <th style="width: 20%" class="text-center">{{ __('tickets.stars') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <i class="fas fa-user-check text-primary {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>
                                        <strong>{{ __('tickets.professionalism') }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary" style="font-size: 1.1rem; padding: 0.5rem 1rem;">{{ $existingReview->professionalism ?? 'N/A' }}/5</span>
                                    </td>
                                    <td class="text-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= ($existingReview->professionalism ?? 0) ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="fas fa-clock text-info {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>
                                        <strong>{{ __('tickets.response_time') }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info" style="font-size: 1.1rem; padding: 0.5rem 1rem;">{{ $existingReview->response_time ?? 'N/A' }}/5</span>
                                    </td>
                                    <td class="text-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= ($existingReview->response_time ?? 0) ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="fas fa-tools text-success {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>
                                        <strong>{{ __('tickets.quality_of_work') }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success" style="font-size: 1.1rem; padding: 0.5rem 1rem;">{{ $existingReview->quality_of_work ?? 'N/A' }}/5</span>
                                    </td>
                                    <td class="text-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= ($existingReview->quality_of_work ?? 0) ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="fas fa-comments text-warning {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>
                                        <strong>{{ __('tickets.communication') }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-warning text-dark" style="font-size: 1.1rem; padding: 0.5rem 1rem;">{{ $existingReview->communication ?? 'N/A' }}/5</span>
                                    </td>
                                    <td class="text-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= ($existingReview->communication ?? 0) ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                    </td>
                                </tr>
                                <tr style="background-color: #fff3cd;">
                                    <td>
                                        <i class="fas fa-smile text-success {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>
                                        <strong>{{ __('tickets.overall_satisfaction') }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success" style="font-size: 1.1rem; padding: 0.5rem 1rem;">{{ $existingReview->overall_satisfaction ?? 'N/A' }}/5</span>
                                    </td>
                                    <td class="text-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= ($existingReview->overall_satisfaction ?? 0) ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        <div class="card bg-light border-0">
                            <div class="card-header bg-secondary text-white">
                                <i class="fas fa-sticky-note {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i><strong>{{ __('tickets.notes') }}</strong>
                            </div>
                            <div class="card-body">
                                @if($existingReview->notes)
                                    <p class="mb-0" style="white-space: pre-wrap; font-size: 1rem; line-height: 1.6;">{{ $existingReview->notes }}</p>
                                @else
                                    <p class="mb-0 text-muted fst-italic">{{ __('tickets.no_notes_provided') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Review form -->
                    <div class="alert alert-info border-info" style="background-color: #cff4fc;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle fa-2x text-info {{ app()->getLocale() == 'ar' ? 'ms-3' : 'me-3' }}"></i>
                            <div>
                                <h6 class="alert-heading mb-1">{{ __('tickets.rate_service') }}</h6>
                                <small class="text-muted">{{ __('tickets.rate_service_desc') }}</small>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('tickets.review.store') }}" class="needs-validation" novalidate id="reviewForm">
                        @csrf
                        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead style="background-color: #e7f1ff;">
                                    <tr>
                                        <th style="width: 50%"><i class="fas fa-clipboard-list {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>{{ __('tickets.criteria') }}</th>
                                        <th style="width: 50%"><i class="fas fa-star {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>{{ __('tickets.rating') }} (0-5)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <i class="fas fa-user-check text-primary {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>
                                            <strong>{{ __('tickets.professionalism') }}</strong>
                                        </td>
                                        <td>
                                            <select name="professionalism" class="form-select @error('professionalism') is-invalid @enderror" required id="professionalism">
                                                <option value="">{{ __('tickets.select_rating') }}</option>
                                                @for($i = 0; $i <= 5; $i++)
                                                    <option value="{{ $i }}" {{ old('professionalism') == $i ? 'selected' : '' }}>
                                                        {{ $i }} {{ $i == 0 ? '⭐ ' . __('tickets.rating_poor') : ($i == 5 ? '⭐⭐⭐⭐⭐ ' . __('tickets.rating_excellent') : str_repeat('⭐', $i)) }}
                                                    </option>
                                                @endfor
                                            </select>
                                            @error('professionalism')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="invalid-feedback professionalism-error"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-clock text-info {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>
                                            <strong>{{ __('tickets.response_time') }}</strong>
                                        </td>
                                        <td>
                                            <select name="response_time" class="form-select @error('response_time') is-invalid @enderror" required id="response_time">
                                                <option value="">{{ __('tickets.select_rating') }}</option>
                                                @for($i = 0; $i <= 5; $i++)
                                                    <option value="{{ $i }}" {{ old('response_time') == $i ? 'selected' : '' }}>
                                                        {{ $i }} {{ $i == 0 ? '⭐ ' . __('tickets.rating_poor') : ($i == 5 ? '⭐⭐⭐⭐⭐ ' . __('tickets.rating_excellent') : str_repeat('⭐', $i)) }}
                                                    </option>
                                                @endfor
                                            </select>
                                            @error('response_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="invalid-feedback response_time-error"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-tools text-success {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>
                                            <strong>{{ __('tickets.quality_of_work') }}</strong>
                                        </td>
                                        <td>
                                            <select name="quality_of_work" class="form-select @error('quality_of_work') is-invalid @enderror" required id="quality_of_work">
                                                <option value="">{{ __('tickets.select_rating') }}</option>
                                                @for($i = 0; $i <= 5; $i++)
                                                    <option value="{{ $i }}" {{ old('quality_of_work') == $i ? 'selected' : '' }}>
                                                        {{ $i }} {{ $i == 0 ? '⭐ ' . __('tickets.rating_poor') : ($i == 5 ? '⭐⭐⭐⭐⭐ ' . __('tickets.rating_excellent') : str_repeat('⭐', $i)) }}
                                                    </option>
                                                @endfor
                                            </select>
                                            @error('quality_of_work')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="invalid-feedback quality_of_work-error"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-comments text-warning {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>
                                            <strong>{{ __('tickets.communication') }}</strong>
                                        </td>
                                        <td>
                                            <select name="communication" class="form-select @error('communication') is-invalid @enderror" required id="communication">
                                                <option value="">{{ __('tickets.select_rating') }}</option>
                                                @for($i = 0; $i <= 5; $i++)
                                                    <option value="{{ $i }}" {{ old('communication') == $i ? 'selected' : '' }}>
                                                        {{ $i }} {{ $i == 0 ? '⭐ ' . __('tickets.rating_poor') : ($i == 5 ? '⭐⭐⭐⭐⭐ ' . __('tickets.rating_excellent') : str_repeat('⭐', $i)) }}
                                                    </option>
                                                @endfor
                                            </select>
                                            @error('communication')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="invalid-feedback communication-error"></div>
                                        </td>
                                    </tr>
                                    <tr style="background-color: #fff3cd;">
                                        <td>
                                            <i class="fas fa-smile text-success {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>
                                            <strong>{{ __('tickets.overall_satisfaction') }}</strong>
                                        </td>
                                        <td>
                                            <select name="overall_satisfaction" class="form-select @error('overall_satisfaction') is-invalid @enderror" required id="overall_satisfaction">
                                                <option value="">{{ __('tickets.select_rating') }}</option>
                                                @for($i = 0; $i <= 5; $i++)
                                                    <option value="{{ $i }}" {{ old('overall_satisfaction') == $i ? 'selected' : '' }}>
                                                        {{ $i }} {{ $i == 0 ? '⭐ ' . __('tickets.rating_poor') : ($i == 5 ? '⭐⭐⭐⭐⭐ ' . __('tickets.rating_excellent') : str_repeat('⭐', $i)) }}
                                                    </option>
                                                @endfor
                                            </select>
                                            @error('overall_satisfaction')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="invalid-feedback overall_satisfaction-error"></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group mt-4">
                            <label for="notes" class="form-label">
                                <i class="fas fa-sticky-note text-secondary {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>
                                <strong>{{ __('tickets.notes') }}:</strong>
                                <small class="text-muted">({{ __('tickets.optional') }})</small>
                            </label>
                            <textarea
                                name="notes"
                                id="notes"
                                class="form-control @error('notes') is-invalid @enderror"
                                rows="5"
                                placeholder="{{ __('tickets.notes_placeholder') }}"
                                style="resize: vertical;">{{ old('notes') }}</textarea>
                            <small class="text-muted">{{ __('tickets.notes_help') }}</small>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback notes-error"></div>
                        </div>

                        <div class="col-12 mt-4" style="text-align: center">
                            <button type="submit" class="btn btn-primary btn-lg px-5" id="submitReview">
                                <i class="fas fa-paper-plane {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>{{ __('tickets.submit_review') }}
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>

        {{-- Return to Ticket Details Button --}}
        <div class="text-center mt-4">
            <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-secondary btn-lg px-5">
                <i class="fas fa-arrow-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>
                {{ __('tickets.return_to_details') }}
            </a>
        </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Add real-time validation for all select fields
        $('#professionalism, #response_time, #quality_of_work, #communication, #overall_satisfaction').on('change blur', function() {
            const field = $(this);
            const fieldName = field.attr('name');
            const fieldValue = field.val();

            // Clear previous error for this field
            $(`.${fieldName}-error`).text('');
            field.removeClass('is-invalid');

            // Validate field
            if (!fieldValue) {
                field.addClass('is-invalid');
                switch(fieldName) {
                    case 'professionalism':
                        $(`.${fieldName}-error`).text('{{ __('tickets.validation.professionalism_required') }}');
                        break;
                    case 'response_time':
                        $(`.${fieldName}-error`).text('{{ __('tickets.validation.response_time_required') }}');
                        break;
                    case 'quality_of_work':
                        $(`.${fieldName}-error`).text('{{ __('tickets.validation.quality_of_work_required') }}');
                        break;
                    case 'communication':
                        $(`.${fieldName}-error`).text('{{ __('tickets.validation.communication_required') }}');
                        break;
                    case 'overall_satisfaction':
                        $(`.${fieldName}-error`).text('{{ __('tickets.validation.overall_satisfaction_required') }}');
                        break;
                }
            }
        });

        // Add real-time validation for notes field (character limit)
        $('#notes').on('input blur', function() {
            const notesValue = $(this).val();

            // Clear previous error
            $('.notes-error').text('');
            $(this).removeClass('is-invalid');

            // Validate notes length
            if (notesValue && notesValue.length > 1000) {
                $(this).addClass('is-invalid');
                $('.notes-error').text('{{ __('tickets.validation.notes_max') }}');
            }
        });

        // Handle form submission
        $('#reviewForm').on('submit', function(e) {
            // Trigger validation on all fields
            $('#professionalism, #response_time, #quality_of_work, #communication, #overall_satisfaction, #notes').trigger('blur');

            // Check if there are any validation errors
            if ($('.is-invalid').length > 0) {
                e.preventDefault();
                return false;
            }
        });
    });
</script>
@endsection
