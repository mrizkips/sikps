<?php

namespace App\Http\Requests;

use App\Models\Pengajuan;
use App\Rules\JadwalPendaftaranActive;
use Illuminate\Foundation\Http\FormRequest;

class PengajuanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', Pengajuan::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'proposal_id' => ['required', 'exists:proposal,id'],
            'jadwal_pendaftaran_id' => ['required', 'exists:jadwal_pendaftaran,id', new JadwalPendaftaranActive]
        ];
    }

    /**
     * Get custom attributes for validator
     *
     * @return array<string>
     */
    public function attributes()
    {
        return [
            'proposal_id' => 'proposal',
            'jadwal_pendaftaran_id' => 'jadwal pendaftaran',
        ];
    }
}
