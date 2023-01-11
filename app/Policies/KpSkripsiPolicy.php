<?php

namespace App\Policies;

use App\Models\KpSkripsi;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class KpSkripsiPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\KpSkripsi  $kpSkripsi
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, KpSkripsi $kpSkripsi)
    {
        //
    }

    /**
     * Determine whether the user can assign dosen
     *
     * @param User $user
     * @param KpSkripsi $kpSkripsi
     * @return bool
     */
    public function assignDosen(User $user, KpSkripsi $kpSkripsi)
    {
        return $user->can('assign dosen kp skripsi');
    }

    /**
     * Determine whether the user can print form bimbingan
     *
     * @param User $user
     * @param KpSkripsi $kpSkripsi
     * @return bool
     */
    public function printFormBimbingan(User $user, KpSkripsi $kpSkripsi)
    {
        return $user->can('print form bimbingan kp skripsi');
    }
}
