<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'printer_code' => 'sometimes|required|numeric|digits:6|between:10601,10699',
            'printer_id' => 'sometimes|required|numeric',
            'user_id' => 'sometimes|required|numeric',
            'problem_type_id' => 'sometimes|required|numeric',
            'department_id' => 'sometimes|required|numeric',
            'description' => 'sometimes|required|string',
            'requester_name' => 'sometimes|required|string',
            'phone' => 'sometimes|required|string',
            'email' => 'nullable|email',
            'image' => 'nullable|image',
            'status' => 'nullable|string',
            'report' => 'sometimes',
        ];
    }

    /**
     * Custom validation messages in multiple locales.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'printer_code.required' => __('tickets.validation.printer_code_required'),
            'printer_code.numeric' => __('tickets.validation.printer_code_numeric'),
            'printer_code.digits' => __('tickets.validation.printer_code_digits'),
            'printer_code.between' => __('tickets.validation.printer_code_between'),

            'printer_id.required' => __('tickets.validation.printer_id_required'),
            'printer_id.numeric' => __('tickets.validation.printer_id_numeric'),

            'user_id.required' => __('tickets.validation.user_id_required', [], app()->getLocale()),
            'user_id.numeric' => __('tickets.validation.user_id_numeric', [], app()->getLocale()),

            'problem_type_id.required' => __('tickets.validation.problem_type_id_required'),
            'problem_type_id.numeric' => __('tickets.validation.problem_type_id_numeric'),

            'department_id.required' => __('tickets.validation.department_id_required'),
            'department_id.numeric' => __('tickets.validation.department_id_numeric'),

            'description.required' => __('tickets.validation.description_required'),
            'description.string' => __('tickets.validation.description_string'),

            'requester_name.required' => __('tickets.validation.requester_name_required'),
            'requester_name.string' => __('tickets.validation.requester_name_string'),

            'phone.required' => __('tickets.validation.phone_required'),
            'phone.string' => __('tickets.validation.phone_string'),

            'email.email' => __('tickets.validation.email_email'),

            'image.image' => __('tickets.validation.image_image'),

            'status.string' => __('tickets.validation.status_string', [], app()->getLocale()),
        ];
    }

    /**
     * Human-friendly attribute names in Arabic.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'printer_code' => __('tickets.printer_code'),
            'printer_id' => __('tickets.printer_model'),
            'user_id' => __('tickets.assigned_technician'),
            'problem_type_id' => __('tickets.problem_type'),
            'department_id' => __('tickets.department'),
            'description' => __('tickets.description'),
            'requester_name' => __('tickets.requester_name'),
            'phone' => __('tickets.phone_number'),
            'email' => __('tickets.email'),
            'image' => __('tickets.problem_image'),
            'status' => __('tickets.ticket_status'),
            'report' => __('tickets.maintenance_report'),
        ];
    }
}
