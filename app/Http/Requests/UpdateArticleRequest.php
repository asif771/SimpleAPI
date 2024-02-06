<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
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
            'title' => [
                'nullable',
                'regex:/^[A-Za-z0-9\s]+$/',
                'min:15',
                'max:55',
            ],
            'description' => [
                'nullable',
                'regex:/^[A-Za-z0-9\s]+$/',
                'min:25',
                'max:255',
            ],
            'image' => [
                'nullable',
                'mimes:jpg,png,jpeg,gif,svg',
                'dimensions:min_width=100,min_height=100',
                'max:2048',
            ],
            'createdBy' => 'nullable|exists:users,id',

        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'The :attribute field is required.',
            'title.regex' => 'This is not a valid :attribute,Only text allowed.',
            'title.min' => 'Minimum 15 Character Allowed.',
            'title.max' => 'Maximum 55 Character Allowed.',
            'description.required' => 'The :attribute field is required.',
            'description.regex' => 'This is not valid :attribute, Only text allowed',
            'description.min' => 'Minimum 25 Character Allowed.',
            'description.max' => 'Maximum 255 Character Allowed.',
            'image.dimensions' => 'The :attribute dimensions must be at least 100x100 pixels.',
            'image.max' => 'The :attribute size must not exceed 2048 KB.',
            'image.mimes' => 'The :attribute mimes should be svg,jpg,png,jpeg,gif.',
        ];
    }

    protected
        $stopOnFirstFailure = true;
}
