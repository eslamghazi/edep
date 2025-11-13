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
                <span style="font-size: 1.5rem;">🧾</span>
            </span>
                {{ __('tickets.review_title') }}
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
                        $avgRating = (
                            ($existingReview->service_quality ?? 0) +
                            ($existingReview->response_time ?? 0) +
                            ($existingReview->technician_behavior ?? 0) +
                            ($existingReview->technician_competence ?? 0)
                        ) / 4;
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
                                        <i class="fas fa-star text-primary {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>
                                        <strong>{{ __('tickets.service_quality') }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary" style="font-size: 1.1rem; padding: 0.5rem 1rem;">{{ $existingReview->service_quality ?? 'N/A' }}/5</span>
                                    </td>
                                    <td class="text-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= ($existingReview->service_quality ?? 0) ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="fas fa-clock text-info {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>
                                        <strong>{{ __('tickets.response_speed') }}</strong>
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
                                        <i class="fas fa-handshake text-success {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>
                                        <strong>{{ __('tickets.technician_behavior') }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success" style="font-size: 1.1rem; padding: 0.5rem 1rem;">{{ $existingReview->technician_behavior ?? 'N/A' }}/5</span>
                                    </td>
                                    <td class="text-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= ($existingReview->technician_behavior ?? 0) ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                    </td>
                                </tr>
                                <tr style="background-color: #fff3cd;">
                                    <td>
                                        <i class="fas fa-tools text-warning {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>
                                        <strong>{{ __('tickets.technician_competence') }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-warning text-dark" style="font-size: 1.1rem; padding: 0.5rem 1rem;">{{ $existingReview->technician_competence ?? 'N/A' }}/5</span>
                                    </td>
                                    <td class="text-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= ($existingReview->technician_competence ?? 0) ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Problem Resolution Status --}}
                    <div class="mt-4">
                        <div class="card border-0" style="background-color: #e8f5e9;">
                            <div class="card-body">
                                <h6 class="mb-3"><strong><i class="fas fa-check-circle text-success {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>{{ __('tickets.problem_resolved') }}</strong></h6>
                                <p class="mb-0" style="font-size: 1.1rem;">
                                    @if($existingReview->problem_solved === 'full')
                                        <span class="badge bg-success" style="padding: 0.5rem 1rem;">✅ {{ __('tickets.fully_resolved') }}</span>
                                    @elseif($existingReview->problem_solved === 'yes_certainly')
                                        <span class="badge bg-success" style="padding: 0.5rem 1rem;">🌟 {{ __('tickets.yes_certainly') }}</span>
                                    @elseif($existingReview->problem_solved === 'partial')
                                        <span class="badge bg-warning text-dark" style="padding: 0.5rem 1rem;">⚙ {{ __('tickets.partially_resolved') }}</span>
                                    @else
                                        <span class="badge bg-danger" style="padding: 0.5rem 1rem;">❌ {{ __('tickets.not_resolved') }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Recommendation Status --}}
                    

                    {{-- Notes Section --}}
                    <div class="mt-3">
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
                                <h6 class="alert-heading mb-2">{{ __('tickets.service_rating_title') }}</h6>
                                <small class="d-block mb-2">{{ __('tickets.service_rating_intro') }}</small>
                                <small>{{ __('tickets.service_rating_desc') }}</small>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('tickets.review.store') }}" class="needs-validation" novalidate id="reviewForm">
                        @csrf
                        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                        {{-- Rating Fields --}}
                        <div class="mt-4">
                            {{-- Field 1: Service Quality --}}
                            <div class="mb-5">
                                <h6 class="mb-3" style="color: #2c3e50; font-weight: 600;"><strong>{{ __('tickets.service_quality') }}</strong></h6>
                                <div class="d-flex gap-2 align-items-center" style="gap: 1rem;">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label style="cursor: pointer; font-size: 2.5rem; transition: all 0.2s;" class="star-label">
                                            <input type="radio" name="service_quality" value="{{ $i }}" {{ old('service_quality') == $i ? 'checked' : '' }} style="display: none;" class="service_quality_radio" required>
                                            <span class="service_quality_star" data-value="{{ $i }}" style="filter: grayscale(100%); opacity: 0.3;">⭐</span>
                                        </label>
                                    @endfor
                                </div>
                                <div class="invalid-feedback d-block" id="service_quality_error" style="display: none !important;"></div>
                                @error('service_quality')
                                    <div class="text-danger mt-2" style="font-size: 0.9rem;"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Field 2: Response Time --}}
                            <div class="mb-5">
                                <h6 class="mb-3" style="color: #2c3e50; font-weight: 600;"><strong>{{ __('tickets.response_speed') }}</strong></h6>
                                <div class="d-flex gap-2 align-items-center" style="gap: 1rem;">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label style="cursor: pointer; font-size: 2.5rem; transition: all 0.2s;" class="star-label">
                                            <input type="radio" name="response_time" value="{{ $i }}" {{ old('response_time') == $i ? 'checked' : '' }} style="display: none;" class="response_time_radio" required>
                                            <span class="response_time_star" data-value="{{ $i }}" style="filter: grayscale(100%); opacity: 0.3;">⭐</span>
                                        </label>
                                    @endfor
                                </div>
                                <div class="invalid-feedback d-block" id="response_time_error" style="display: none !important;"></div>
                                @error('response_time')
                                    <div class="text-danger mt-2" style="font-size: 0.9rem;"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Field 3: Technician Behavior --}}
                            <div class="mb-5">
                                <h6 class="mb-3" style="color: #2c3e50; font-weight: 600;"><strong>{{ __('tickets.technician_behavior') }}</strong></h6>
                                <div class="d-flex gap-2 align-items-center" style="gap: 1rem;">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label style="cursor: pointer; font-size: 2.5rem; transition: all 0.2s;" class="star-label">
                                            <input type="radio" name="technician_behavior" value="{{ $i }}" {{ old('technician_behavior') == $i ? 'checked' : '' }} style="display: none;" class="technician_behavior_radio" required>
                                            <span class="technician_behavior_star" data-value="{{ $i }}" style="filter: grayscale(100%); opacity: 0.3;">⭐</span>
                                        </label>
                                    @endfor
                                </div>
                                <div class="invalid-feedback d-block" id="technician_behavior_error" style="display: none !important;"></div>
                                @error('technician_behavior')
                                    <div class="text-danger mt-2" style="font-size: 0.9rem;"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Field 4: Technician Competence --}}
                            <div class="mb-5">
                                <h6 class="mb-3" style="color: #2c3e50; font-weight: 600;"><strong>{{ __('tickets.technician_competence') }}</strong></h6>
                                <div class="d-flex gap-2 align-items-center" style="gap: 1rem;">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label style="cursor: pointer; font-size: 2.5rem; transition: all 0.2s;" class="star-label">
                                            <input type="radio" name="technician_competence" value="{{ $i }}" {{ old('technician_competence') == $i ? 'checked' : '' }} style="display: none;" class="technician_competence_radio" required>
                                            <span class="technician_competence_star" data-value="{{ $i }}" style="filter: grayscale(100%); opacity: 0.3;">⭐</span>
                                        </label>
                                    @endfor
                                </div>
                                <div class="invalid-feedback d-block" id="technician_competence_error" style="display: none !important;"></div>
                                @error('technician_competence')
                                    <div class="text-danger mt-2" style="font-size: 0.9rem;"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Field 5: Problem Resolution --}}
                            <div class="mb-5">
                                <h6 class="mb-3" style="color: #2c3e50; font-weight: 600;"><strong>{{ __('tickets.problem_resolved') }}</strong></h6>
                                <div class="d-flex gap-3 flex-wrap" style="gap: 1.5rem;">
                                    <label class="resolution-option" style="cursor: pointer; padding: 15px 25px; border: 2px solid #e0e0e0; border-radius: 10px; transition: all 0.3s; background: white;">
                                        <input type="radio" name="problem_solved" value="yes_certainly" {{ old('problem_solved') == 'yes_certainly' ? 'checked' : '' }} style="margin-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 10px;" required>
                                        <span style="font-size: 1.3rem;">🌟 {{ __('tickets.yes_certainly') }}</span>
                                    </label>
                                    <label class="resolution-option" style="cursor: pointer; padding: 15px 25px; border: 2px solid #e0e0e0; border-radius: 10px; transition: all 0.3s; background: white;">
                                        <input type="radio" name="problem_solved" value="full" {{ old('problem_solved') == 'full' ? 'checked' : '' }} style="margin-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 10px;" required>
                                        <span style="font-size: 1.3rem;">✅ {{ __('tickets.fully_resolved') }}</span>
                                    </label>
                                    <label class="resolution-option" style="cursor: pointer; padding: 15px 25px; border: 2px solid #e0e0e0; border-radius: 10px; transition: all 0.3s; background: white;">
                                        <input type="radio" name="problem_solved" value="partial" {{ old('problem_solved') == 'partial' ? 'checked' : '' }} style="margin-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 10px;" required>
                                        <span style="font-size: 1.3rem;">⚙ {{ __('tickets.partially_resolved') }}</span>
                                    </label>
                                    <label class="resolution-option" style="cursor: pointer; padding: 15px 25px; border: 2px solid #e0e0e0; border-radius: 10px; transition: all 0.3s; background: white;">
                                        <input type="radio" name="problem_solved" value="no" {{ old('problem_solved') == 'no' ? 'checked' : '' }} style="margin-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 10px;" required>
                                        <span style="font-size: 1.3rem;">❌ {{ __('tickets.not_resolved') }}</span>
                                    </label>
                                </div>
                                <div class="invalid-feedback d-block" id="problem_solved_error" style="display: none !important;"></div>
                                @error('problem_solved')
                                    <div class="text-danger mt-2" style="font-size: 0.9rem;"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            
                        </div>

                        {{-- Notes Field --}}
                        <div class="form-group mt-4 mb-4">
                            <label for="notes" class="form-label" style="color: #2c3e50; font-weight: 600;">
                                <i class="fas fa-sticky-note text-secondary {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>
                                <strong>{{ __('tickets.suggestions') }}:</strong>
                                <small class="text-muted">({{ __('tickets.optional') }})</small>
                            </label>
                            <textarea
                                name="notes"
                                id="notes"
                                class="form-control @error('notes') is-invalid @enderror"
                                rows="5"
                                placeholder="{{ __('tickets.suggestions_placeholder') }}"
                                style="resize: vertical; border: 2px solid #e0e0e0; border-radius: 10px; padding: 15px; font-size: 1rem;">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mt-5 mb-4" style="text-align: center">
                            <button type="submit" class="btn btn-info btn-lg px-5 py-3" id="submitReview" style="font-size: 1.2rem; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: all 0.3s; background: #17a2b8;">
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
        // Validation messages
        const validationMessages = {
            'service_quality': '{{ __('tickets.service_quality') }} {{ __('tickets.required_field') }}',
            'response_time': '{{ __('tickets.response_speed') }} {{ __('tickets.required_field') }}',
            'technician_behavior': '{{ __('tickets.technician_behavior') }} {{ __('tickets.required_field') }}',
            'technician_competence': '{{ __('tickets.technician_competence') }} {{ __('tickets.required_field') }}',
            'problem_solved': '{{ __('tickets.problem_resolved') }} {{ __('tickets.required_field') }}'
        };

        // Function to show error
        function showError(fieldName, message) {
            const errorDiv = $('#' + fieldName + '_error');
            errorDiv.html('<i class="fas fa-exclamation-circle me-1"></i>' + message);
            errorDiv.css('display', 'block');
            errorDiv.css('color', '#dc3545');
            errorDiv.css('font-size', '0.9rem');
            errorDiv.css('margin-top', '0.5rem');
        }

        // Function to hide error
        function hideError(fieldName) {
            const errorDiv = $('#' + fieldName + '_error');
            errorDiv.css('display', 'none');
            errorDiv.html('');
        }

        // Function to validate field
        function validateField(fieldName) {
            const value = $('input[name="' + fieldName + '"]:checked').val();
            if (!value) {
                showError(fieldName, validationMessages[fieldName]);
                return false;
            } else {
                hideError(fieldName);
                return true;
            }
        }

        // Interactive star rating with hover effect for service quality
        $('.service_quality_star').on('click', function() {
            const value = $(this).data('value');
            $('.service_quality_radio[value="' + value + '"]').prop('checked', true);
            updateStars('.service_quality_star', value);
            validateField('service_quality');
        });
        $('.service_quality_star').hover(
            function() { updateStars('.service_quality_star', $(this).data('value')); },
            function() {
                const checkedValue = $('.service_quality_radio:checked').val() || 0;
                updateStars('.service_quality_star', checkedValue);
            }
        );

        // Interactive star rating for response time
        $('.response_time_star').on('click', function() {
            const value = $(this).data('value');
            $('.response_time_radio[value="' + value + '"]').prop('checked', true);
            updateStars('.response_time_star', value);
            validateField('response_time');
        });
        $('.response_time_star').hover(
            function() { updateStars('.response_time_star', $(this).data('value')); },
            function() {
                const checkedValue = $('.response_time_radio:checked').val() || 0;
                updateStars('.response_time_star', checkedValue);
            }
        );

        // Interactive star rating for technician behavior
        $('.technician_behavior_star').on('click', function() {
            const value = $(this).data('value');
            $('.technician_behavior_radio[value="' + value + '"]').prop('checked', true);
            updateStars('.technician_behavior_star', value);
            validateField('technician_behavior');
        });
        $('.technician_behavior_star').hover(
            function() { updateStars('.technician_behavior_star', $(this).data('value')); },
            function() {
                const checkedValue = $('.technician_behavior_radio:checked').val() || 0;
                updateStars('.technician_behavior_star', checkedValue);
            }
        );

        // Interactive star rating for technician competence
        $('.technician_competence_star').on('click', function() {
            const value = $(this).data('value');
            $('.technician_competence_radio[value="' + value + '"]').prop('checked', true);
            updateStars('.technician_competence_star', value);
            validateField('technician_competence');
        });
        $('.technician_competence_star').hover(
            function() { updateStars('.technician_competence_star', $(this).data('value')); },
            function() {
                const checkedValue = $('.technician_competence_radio:checked').val() || 0;
                updateStars('.technician_competence_star', checkedValue);
            }
        );

        // Function to update star appearance
        function updateStars(selector, value) {
            $(selector).each(function() {
                if ($(this).data('value') <= value) {
                    $(this).css({
                        'filter': 'grayscale(0%)',
                        'opacity': '1',
                        'transform': 'scale(1.1)',
                        'text-shadow': '0 0 10px rgba(255, 193, 7, 0.5)'
                    });
                } else {
                    $(this).css({
                        'filter': 'grayscale(100%)',
                        'opacity': '0.3',
                        'transform': 'scale(1)',
                        'text-shadow': 'none'
                    });
                }
            });
        }

        // Add hover effects for problem solved options
        $('.resolution-option').hover(
            function() { $(this).css({'border-color': '#4CAF50', 'background': '#f1f8f4', 'transform': 'scale(1.05)'}); },
            function() {
                if (!$(this).find('input').is(':checked')) {
                    $(this).css({'border-color': '#e0e0e0', 'background': 'white', 'transform': 'scale(1)'});
                }
            }
        );
        $('.resolution-option input').on('change', function() {
            $('.resolution-option').css({'border-color': '#e0e0e0', 'background': 'white'});
            $(this).closest('.resolution-option').css({'border-color': '#4CAF50', 'background': '#f1f8f4'});
            validateField('problem_solved');
        });

        // Recommendation input removed; hover and change handlers not needed.

        // Submit button hover effect
        $('#submitReview').hover(
            function() { $(this).css({'transform': 'translateY(-2px)', 'box-shadow': '0 6px 12px rgba(0,0,0,0.15)'}); },
            function() { $(this).css({'transform': 'translateY(0)', 'box-shadow': '0 4px 6px rgba(0,0,0,0.1)'}); }
        );

        // Handle form submission with validation
        $('#reviewForm').on('submit', function(e) {
            let isValid = true;

            // Validate all fields
            if (!validateField('service_quality')) isValid = false;
            if (!validateField('response_time')) isValid = false;
            if (!validateField('technician_behavior')) isValid = false;
            if (!validateField('technician_competence')) isValid = false;
            if (!validateField('problem_solved')) isValid = false;

            if (!isValid) {
                e.preventDefault();
                // Scroll to first error
                $('html, body').animate({
                    scrollTop: $('.invalid-feedback:visible').first().offset().top - 100
                }, 500);
            }
        });
    });
</script>
@endsection