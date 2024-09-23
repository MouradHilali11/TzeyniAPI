<?php

namespace App\Http\Requests\Professionals;

use Illuminate\Foundation\Http\FormRequest;

class RegisterProfesRequest extends FormRequest
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
            'email'=>'required|email|string|unique:professionals,email',
            'phone'=>'required|string|unique:professionals,phone|max:100',
            'city'=>'required|string|max:120',
            'address'=>'required|string',
            'password'=>'required|string|confirmed|min:8'
        ];
    }
}
