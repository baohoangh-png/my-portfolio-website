<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $productId = $this->route('id');
        return [
            'proname' => [
                'bail',
                'required',
                'string',
                'min:1',
                'max:100',
                'regex:/^[\p{L}0-9\s]+$/u',
                'unique:products,proname,' . $productId,
            ],
            'price' => [
                'bail',
                'required',
                'numeric',
                'between:1,100000000',
            ],
            'cateid' => [
                'bail',
                'required',
                'exists:categories,cateid',
            ],
            'brandid' => [
                'bail',
                'nullable',
                'exists:brands,id',
            ],
            'description' => [
                'bail',
                'required',
                'regex:/^[^@#$]*$/',
            ],
            'fileName' => [
                'bail',
                'nullable',
                'image',
                'mimes:jpeg,png,jpg',
                'max:10000',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute bắt buộc nhập.',
            'string' => ':attribute phải là chuỗi.',
            'min' => ':attribute tối thiểu :min ký tự.',
            'max' => ':attribute tối đa :max ký tự.',
            'fileName.max' => ':attribute phải <200kb.',
            'unique' => ':attribute đã tồn tại.',
            'numeric' => ':attribute phải là số.',
            'between' => ':attribute phải từ :min đến :max.',
            'exists' => ':attribute không tồn tại trong hệ thống.',
            'proname.regex' => ':attribute chỉ chứa chữ cái, số và khoảng trắng.',
            'description.regex' => ':attribute không được chứa @, # hoặc $.',
        ];
    }

    public function attributes(): array
    {
        return [
            'proname' => 'Tên sản phẩm',
            'price' => 'Giá',
            'cateid' => 'Loại sản phẩm',
            'brandid' => 'Thương hiệu',
            'fileName' => 'Ảnh sản phẩm',
        ];
    }
}
