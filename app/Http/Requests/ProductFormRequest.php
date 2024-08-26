<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFormRequest extends FormRequest
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
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:200',
            'price' => 'required|min:0',
            'expiry_date' => 'required|date|after_or_equal:today',
            'category_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.max' => 'O nome não pode exceder 50 caracteres.',
            'description.required' => 'A descrição é obrigatório.',
            'description.max' => 'A descrição não pode exceder 200 caracteres.',
            'price.required' => 'O preço é obrigatório.',
            'price.min' => 'O preço deve ser um valor positivo.',
            'expiry_date.required' => 'A data de validade é obrigatória.',
            'expiry_date.after_or_equal' => 'A data de validade não pode ser anterior à data atual.',
            'category_id.required' => 'A categoria do produto é obrigatório.',
        ];

    }
}
