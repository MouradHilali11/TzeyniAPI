<?php

namespace App\Http\Requests\Professionals;

use Illuminate\Foundation\Http\FormRequest;

class LoginProfesLogin extends FormRequest
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
            'email' => 'required|email|exists:professionals,email',
            'password' => 'required|string|min:8'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'We need your email address to log you in.',
            'password.required' => 'Please enter your password.',
        ];
    }
}
