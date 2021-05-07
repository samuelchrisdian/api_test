<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateStock extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'required|string',
			'stock' => 'required|numeric',
			'harga' => 'required|numeric',
        ];
    }
    public function messages() {
        return [
            'description.required' => 'Description tidak bisa kosong',
            'stock.required' => 'Stock tidak bisa kosong',
            'harga.required' => 'Harga tidak bisa kosong',
        ];
    }
}
