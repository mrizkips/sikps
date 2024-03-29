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
        return $user->can('view any kp skripsi');
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
        if ($user->hasRole('Mahasiswa')) {
            return $user->can('view kp skripsi') && $kpSkripsi->mahasiswa_id === $user->mahasiswa->id;
        }

        return $user->can('view kp skripsi');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User      $user
     * @param  \App\Models\KpSkripsi $kpSkripsi
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, KpSkripsi $kpSkripsi)
    {
        if ($kpSkripsi->pengajuan->status == '5') {
            return false;
        }

        return $user->can('update kp skripsi');
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
        if ($kpSkripsi->pengajuan->status == '5') {
            return false;
        }

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
        if (!$kpSkripsi->hasDosenPembimbing()) {
            return false;
        }

        if ($user->hasRole('Mahasiswa') && $kpSkripsi->hasPrintedFormBimbingan()) {
            return false;
        }

        if ($kpSkripsi->pengajuan->status == '5') {
            return false;
        }

        return $user->can('print form bimbingan kp skripsi');
    }

    /**
     * Determine whether the user can graduate the students
     *
     * @param   User $user
     * @param   KpSkripsi $kpSkripsi
     * @return  bool
     */
    public function graduate(User $user, KpSkripsi $kpSkripsi)
    {
        if (!$kpSkripsi->hasDosenPembimbing()) {
            return false;
        }

        if ($user->hasRole('Mahasiswa')) {
            return false;
        }

        if ($kpSkripsi->pengajuan->status == '5') {
            return false;
        }

        return $user->can('graduate kp skripsi');
    }
}
