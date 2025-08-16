<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            // Optional password field
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed', // must match password_confirmation
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
            ],
            // Current password is required only if user wants to update password
            'current_password' => ['required_with:password'],
        ];
    }

    /**
     * Custom messages for validation
     */
    public function messages(): array
    {
        return [
            'password.regex' => 'Password must be at least 8 characters long, include uppercase and lowercase letters, a number, and a special character.',
            'current_password.required_with' => 'You must enter your current password to set a new password.',
        ];
    }
}
