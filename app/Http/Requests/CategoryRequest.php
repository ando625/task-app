<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Override;

class CategoryRequest extends FormRequest
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
            'name' => [
                'string',
                'required',
                'max:255',
                Rule::unique('categories','name')->ignore($this->category),
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'カテゴリー名は必須です。',
            'name.max' => 'カテゴリー名は255文字以内で入力してください。',
            'name.unique' => 'このカテゴリー名は既に使用されています。',
        ];
    }
}
