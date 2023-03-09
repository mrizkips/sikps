<?php

namespace App\Http\Requests;

use App\Models\KpSkripsi;
use Illuminate\Foundation\Http\FormRequest;

class EditJudulProposalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', KpSkripsi::find($this->route('kp_skripsi')->id));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'judul' => ['required', 'string','different:judul_lama'],
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
            'judul' => 'judul baru',
        ];
    }
}
