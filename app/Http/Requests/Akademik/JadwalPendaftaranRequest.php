<?php

namespace App\Http\Requests\Akademik;

use App\Models\JadwalPendaftaran;
use Illuminate\Foundation\Http\FormRequest;

class JadwalPendaftaranRequest extends FormRequest
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
                return $this->user()->can('create', JadwalPendaftaran::class);

            case 'PUT':
                $jadwal_pendaftaran = JadwalPendaftaran::find($this->route('jadwal_pendaftaran')->id);
                return $jadwal_pendaftaran && $this->user()->can('update', $jadwal_pendaftaran);

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
        if ($this->input('periode') != null) {
            $periode = explode(' - ', $this->input('periode'));
            $this->merge(['tgl_pembukaan' => $periode[0], 'tgl_penutupan' => $periode[1]]);
        }

        return [
            'judul' => ['required', 'string'],
            'jenis' => ['required', 'in:1,2,3'],
            'tgl_pembukaan' => ['required', 'date'],
            'tgl_penutupan' => ['required', 'date', 'after_or_equal:tgl_pembukaan'],
            'semester' => ['required', 'in:1,2,3'],
            'tahun_akademik_id' => ['required', 'exists:tahun_akademik,id'],
        ];
    }

    /**
     * Custom attribute name
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'tgl_pembukaan' => 'tanggal pembukaan',
            'tgl_penutupan' => 'tanggal penutupan',
            'tahun_akademik_id' => 'tahun akademik',
        ];
    }
}
