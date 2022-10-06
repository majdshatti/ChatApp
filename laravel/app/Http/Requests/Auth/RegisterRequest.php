<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "username" => "required|string|min:2|max:20|unique:users,username",
            "email" => "required|string|email|unique:users,email",
            "phone_number" => "required|string|max:11|unique:users,phone_number",
            "password" => "required|string|min:6|confirmed",
        ];
    }
}
