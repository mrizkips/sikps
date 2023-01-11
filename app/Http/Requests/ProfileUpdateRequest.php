<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'jk' => ['nullable', 'in:L,P'],
            'email' => ['nullable', 'string', 'email'],
            'no_hp' => ['nullable', 'numeric'],
        ];
    }

    /**
     * Custom attribute name
     *
     * @return array<string>
     */
    public function attributes()
    {
        return [
            'jk' => 'jenis kelamin',
            'no_hp' => 'nomor handphone',
        ];
    }
}
