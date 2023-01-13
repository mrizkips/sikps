<?php

namespace App\Http\Requests\User;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
                return $this->user()->can('create', User::class);

            case 'PUT':
                $user = User::find($this->route('user')->id);
                return $user && $this->user()->can('update', $user);

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
        $rules = [
            'nama' => ['required', 'string'],
            'jk' => ['nullable', 'in:L,P'],
            'email' => ['nullable', 'string'],
            'no_hp' => ['nullable', 'numeric', 'max_digits:15'],
        ];

        if ($this->isMahasiswa()) {
            $rules = array_merge($rules, [
                'jurusan' => ['required', 'in:1,2'],
            ]);
        }

        switch ($this->method()) {
            case 'POST':
                $rules = array_merge($rules, [
                    'username' => ['required', 'unique:users'],
                    'roles' => ['required', 'array'],
                    'roles.*' => ['exists:roles,name'],
                ]);

                if ($this->isMahasiswa()) {
                    $rules = array_merge($rules, [
                        'nim' => ['required', 'string', 'unique:mahasiswa', 'size:7'],
                    ]);
                }

                if ($this->isDosen()) {
                    $rules = array_merge($rules, [
                        'kd_dosen' => ['required', 'string', 'unique:dosen', 'max:5'],
                        'nidn' => ['nullable', 'string', 'unique:dosen'],
                        'inisial' => ['required', 'string', 'unique:dosen', 'max:5'],
                    ]);
                }

                return $rules;

            case 'PUT':
                $rules = array_merge($rules, [
                    'username' => ['required', Rule::unique(User::class)->ignore($this->route('user')->id)],
                ]);

                if ($this->has('roles')) {
                    $rules = array_merge($rules, [
                        'roles' => ['required', 'array'],
                        'roles.*' => ['exists:roles,name'],
                    ]);

                    if ($this->isMahasiswa()) {
                        $rules = array_merge($rules, [
                            'nim' => ['required', 'string', Rule::unique(Mahasiswa::class)->ignore($this->route('user')->mahasiswa->id ?? null), 'size:7'],
                        ]);
                    }

                    if ($this->isDosen()) {
                        $rules = array_merge($rules, [
                            'kd_dosen' => ['required', 'string', Rule::unique(Dosen::class)->ignore($this->route('user')->dosen->id ?? null), 'max:5'],
                            'nidn' => ['nullable', 'string', Rule::unique(Dosen::class)->ignore($this->route('user')->dosen->id ?? null)],
                            'inisial' => ['required', 'string', Rule::unique(Dosen::class)->ignore($this->route('user')->dosen->id ?? null), 'max:5'],
                        ]);
                    }
                }

                return $rules;
        }

        return $rules;
    }

    /**
     * Filter input roles yang mengandung Mahasiswa
     *
     * @return bool
     */
    public function isMahasiswa(): bool
    {
        return collect($this->input('roles'))->contains('Mahasiswa');
    }

    /**
     * Filter input roles yang mengandung Dosen
     *
     * @return bool
     */
    public function isDosen(): bool
    {
        return collect($this->input('roles'))->contains('Dosen');
    }

    public function generateDefaultPassword()
    {
        return $this->input('username') . '@sikps';
    }
}
