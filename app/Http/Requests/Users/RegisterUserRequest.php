<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'full_name'=>'required|string|max:200',
            'gender'=>'required|string|in:Male,Female|max:100',
            'email'=>'required|email|string|unique:users,email',
            'phone'=>'required|string|unique:users,phone|max:100',
            'city'=>'required|string|max:120',
            'address'=>'required|string',
            'password'=>'required|string|confirmed|min:8'
        ];
    }
}
