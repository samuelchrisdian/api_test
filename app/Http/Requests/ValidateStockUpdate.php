<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateStockUpdate extends FormRequest
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
            'material_code' => 'required|string',
            'description' => 'required|string',
			'stock' => 'required|numeric',
			'unit' => 'required|string',
			'harga' => 'required|numeric',
        ];
    }
    public function messages() {
        return [
            'material_code.required' => 'Material Code tidak bisa kosong',  
            'description.required' => 'Description tidak bisa kosong',
            'stock.required' => 'Stock tidak bisa kosong',
            'unit.required' => 'Unit tidak bisa kosong',
            'harga.required' => 'Harga tidak bisa kosong',
        ];
    }
}
