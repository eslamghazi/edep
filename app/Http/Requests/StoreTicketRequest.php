<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
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
            'printer_code' => 'required|numeric|digits:6|between:10601,10699',
            'printer_id' => 'required|numeric',
            'problem_type_id' => 'required|numeric',
            'department_id' => 'required|numeric',
            'description' => 'required|string',
            'requester_name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'nullable|email',
            'image' => 'nullable|image',
        ];
    }

    /**
     * Get custom validation messages.
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
        ];
    }
}
