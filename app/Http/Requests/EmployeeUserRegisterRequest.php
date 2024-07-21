<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeUserRegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employee_users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8',
            'address' => 'required|string',
            'profile' => 'required|file|image|mimes:jpeg,jpg|max:2048',
            'amount_earned' => 'nullable|numeric|min:0',
            'rating' => 'nullable|numeric|between:0,5',
            'hourly_rate' => 'nullable|numeric|min:0',
            'job_id' => 'nullable|exists:jobs,id',
            'total_job_done_count' => 'nullable|integer|min:0',
            'govt_id' => 'nullable|string|max:255',
            'job_category_id' => 'nullable|exists:job_categories,id',
            'location_latitude' => 'nullable|numeric|between:-90,90',
            'location_longitude' => 'nullable|numeric|between:-180,180',
            'bank_account' => 'nullable|string|max:255',
            'ifsc' => 'nullable|string|max:11',
            'bank_name' => 'nullable|string|max:255',
            'bank_address' => 'nullable|string',
            'joining_date' => 'nullable|date',
        ];
    }
}
