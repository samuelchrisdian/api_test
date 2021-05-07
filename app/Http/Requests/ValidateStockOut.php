<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateStockOut extends FormRequest
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
			'id_stock' => 'required|numeric',
			'id_pelanggan' => 'required|numeric',
			'stock' => 'required|numeric',
			'created_at' => 'required|date',
        ];
    }
    public function messages() {
        return [
            'id_stock.required' => 'Stock tidak bisa kosong',
            'id_pelanggan.required' => 'Pelanggan tidak bisa kosong',
            'stock.required' => 'Stock tidak bisa kosong',
            'stock.numeric' => 'Stock harus berupa angka',
            'created_at.required' => 'Tanggal tidak bisa kosong',
        ];
    }
}
