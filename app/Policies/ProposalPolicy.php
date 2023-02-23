<?php

namespace App\Policies;

use App\Models\KpSkripsi;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProposalPolicy
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
        return $user->can('view any proposal');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Proposal $proposal)
    {
        if ($user->hasRole('Dosen')) {
            return false;
        }

        return $user->can('view proposal') && $proposal->mahasiswa->id === $user->mahasiswa->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create proposal');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Proposal $proposal)
    {
        if ($proposal->pengajuan->isNotEmpty()) {
            return false;
        }

        return $user->can('update proposal') && $proposal->mahasiswa->id === $user->mahasiswa->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Proposal $proposal)
    {
        if ($proposal->pengajuan->isNotEmpty()) {
            return false;
        }

        return $user->can('delete proposal') && $proposal->mahasiswa->id === $user->mahasiswa->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function send(User $user, Proposal $proposal)
    {
        if ($proposal->pengajuan->isNotEmpty()) {
            return false;
        }

        $kpSkripsi = KpSkripsi::byMahasiswaId($proposal->mahasiswa->id)
            ->byJenis($proposal->jenis)
            ->count();

        if ($kpSkripsi > 0) {
            return false;
        }

        return $user->can('create pengajuan');
    }
}
