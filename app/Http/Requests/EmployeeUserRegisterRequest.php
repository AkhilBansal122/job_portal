<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Job;

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
            'job_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('user_jobs'),
            ],
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employee_users|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'select_job_id' => 'nullable',  // removed exists:jobs,id
            'adhar_card_number' => 'nullable|string',
            'adhar_card_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:1999',
        ];
    }
}
