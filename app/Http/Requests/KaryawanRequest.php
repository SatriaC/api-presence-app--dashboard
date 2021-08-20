<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KaryawanRequest extends FormRequest
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
            'nama' => 'required|max:255',
            'no_hp' => 'required|max:15',
            'email' => 'required|email',
            'id_bagian' => 'required',
            'nik' => 'required',
            'id_wilayah' => 'required',
            'id_lokasi' => 'required',
            'privilege' => 'required',
        ];
    }
}
