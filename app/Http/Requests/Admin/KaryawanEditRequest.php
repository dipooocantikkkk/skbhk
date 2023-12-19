<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class KaryawanEditRequest extends FormRequest
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
    public function rules()
    { 
        $rules =[
            'nik'=>[
                'required',
                'string',
            ],
            'nama'=>[
                'required',
                'string',
                'max:100'
            ],
            'tempat_lahir'=>[
                'required',
                'string',
            ],
            'tanggal_lahir'=>[
                'required',
                'date',
            ],
            'pendidikan'=>[
                'required',
                'string',
            ],
            'jabatan'=>[
                'required',
                'string',
            ],
            'group_employee'=>[
                'required',
                'string',
            ],
            'no_surat'=>[
                'required',
                'string',
            ],
            'tgl_awal_hubker'=>[
                'required',
                'date'
            ],
            'tgl_akhir_hubker'=>[
                'nullable',
                'date',
            ],  
            'jenis_pkwt'=> [
                'nullable',
                'string'
            ],
            'no_pkwt'=>[
                'nullable',
                'string',
            ],
            'tgl_pkwt'=>[
            'nullable',
            'date'       
            ],
            'nama_pt'=>[
            'nullable',
            'string'
            ],
            'nama_toko'=>[
                'nullable',
                'string'
            ]
        ];
        return $rules;
    }
}
