<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MasterTokoRequest extends FormRequest
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
        $rules =[
            'nama_toko'=>[
                'required',
                'string',
            ],
            'alamat'=>[
                'required',
                'string',
            ],
            'nama_pt'=>[
                'required',
                'string',
            ],
        ];
        return $rules;
    }
}
