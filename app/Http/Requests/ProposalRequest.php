<?php

namespace App\Http\Requests;

use App\Models\KpSkripsi;
use App\Models\Proposal;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProposalRequest extends FormRequest
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
                return $this->user()->can('create', Proposal::class);

            case 'PUT':
                $proposal = Proposal::find($this->route('proposal')->id);
                return $proposal && $this->user()->can('update', $proposal);

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
        $jenis = KpSkripsi::byMahasiswaId($this->user()->mahasiswa->id)
            ->where('jenis', $this->input('jenis'))
            ->get()
            ->map(function ($value, $i) {
            return $value->jenis;
        });

        $rules = [
            'judul' => ['required', 'string'],
            'jenis' => ['required', 'in:1,2', Rule::notIn($jenis)],
            'deskripsi' => ['required', 'string'],
            'organisasi' => ['required_if:jenis,1', 'string']
        ];

        switch ($this->method()) {
            case 'POST':
                $rules = array_merge($rules, [
                    'file_proposal' => ['required', 'file', 'mimes:pdf', 'max:5120']
                ]);
                return $rules;

            case 'PUT':
                $rules = array_merge($rules, [
                    'file_proposal' => ['nullable', 'file', 'mimes:pdf', 'max:5120']
                ]);
                return $rules;

            default:
                return $rules;
        }
    }

    /**
     * Custom attribute name
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'file_proposal' => 'file proposal'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'organisasi.required_if' => ':attribute harus diisi jika jenis adalah kerja praktek.',
            'jenis.not_in' => ':attribute yang dipilih tidak tersedia.'
        ];
    }

    /**
     * Upload proposal
     *
     * @return bool|string
     */
    public function uploadProposal($path = 'proposal', $disk = 'local')
    {
        return $this->file('file_proposal')->store($path, $disk);
    }
}
