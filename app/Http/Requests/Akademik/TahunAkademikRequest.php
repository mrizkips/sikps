<?php

namespace App\Http\Requests\Akademik;

use App\Models\TahunAkademik;
use Illuminate\Foundation\Http\FormRequest;

class TahunAkademikRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        switch ($this->method()) {
            case 'POST':
                return $this->user()->can('create', TahunAkademik::class);

            default:
                return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'tahun_awal' => ['required', 'numeric', 'unique:tahun_akademik']
        ];
    }

    public function tahunAkademikData()
    {
        $tahun_akhir = $this->input('tahun_awal') + 1;
        $nama = $this->input("tahun_awal") . '/' . $tahun_akhir;

        return [
            'tahun_awal' => $this->input('tahun_awal'),
            'tahun_akhir' => $tahun_akhir,
            'nama' => $nama,
        ];
    }

    public function attributes()
    {
        return [
            'tahun_awal' => 'tahun akademik'
        ];
    }
}
