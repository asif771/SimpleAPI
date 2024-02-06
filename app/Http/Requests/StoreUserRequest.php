<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'bail',
                'required',
                'regex:/^[A-Za-z0-9\s]+$/',
                'min:2',
                'max:25',
            ],
            'email' => [
                'bail',
                'required',
                'email',
                Rule::unique('users')->ignore($this->user),
            ],
            'password' => [
                'bail',
                'required',
                'min:8',
                'regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[0-9]).*$/',
                'confirmed',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The :attribute  is required.',
            'name.regex' => 'This is not valid :attribute,only words,or words with numbers allowed',
            'name.min' => 'minimum 3 character allowed.',
            'name.max' => 'minimum 25 character allowed..',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'The email address is already taken.',
            'phoneNumber.min' => 'minimum 11 digit allowed.',
            'password.required' => 'The password field is required.',
            'password.regex' => 'include word number and special character.',
            'password.min' => 'The password must be at least 8 characters.',
        ];
    }

    protected
        $stopOnFirstFailure = true;
}
