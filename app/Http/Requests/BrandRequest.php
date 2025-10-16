<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
        $brandId = $this->route('id');
        return [
            'brandname' => [
                'bail',
                'required',
                'string',
                'min:1',
                'max:100',
                'unique:brands,brandname,' . $brandId,
            ],
            'description' => [
                'bail',
                'required',
                'regex:/^[^@#$]*$/'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute bắt buộc nhập.',

            'brandname.min' => ':attribute phải từ 1 ký tự.',
            'brandname.max' => ':attribute không vượt quá 100 ký tự.',
            'brandname.unique' => ':attribute đã tồn tại.',
            'description.regex' => ':attribute được chứa @, # hoặc $.',
        ];
    }

    public function attributes()
    {
        return
            [
                'brandname' => 'Tên thương hiệu',
                'description' => 'Mô tả'
            ];
    }
}
