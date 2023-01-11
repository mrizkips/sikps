<?php

namespace App\Rules;

use App\Models\JadwalPendaftaran;
use Illuminate\Contracts\Validation\InvokableRule;

class JadwalPendaftaranActive implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $jadwalPendaftaran = JadwalPendaftaran::find($value);

        if ($jadwalPendaftaran->tgl_pembukaan >= now() && today() >= $jadwalPendaftaran->tgl_penutupan) {
            $fail(':attribute sudah kadaluarsa.');
        }
    }
}
