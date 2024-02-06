<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
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
            'title' => [
                'bail',
                'required',
                'string',
            ],
            'description' => [
                'bail',
                'required',
                'string',
                'max:255'
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
            'image.dimensions' => 'The :attribute dimensions must be at least 100x100 pixels.',
            'image.max' => 'The :attribute size must not exceed 2048 KB.',
            'image.mimes' => 'The :attribute mimes should be svg,jpg,png,jpeg,gif.',
        ];
    }

    protected
        $stopOnFirstFailure = true;
}
