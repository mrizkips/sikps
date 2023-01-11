<?php

namespace App\Policies;

use App\Models\User;
use App\Models\JadwalPendaftaran;
use Illuminate\Auth\Access\HandlesAuthorization;

class JadwalPendaftaranPolicy
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
        return $user->can('view any akademik');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create akademik');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JadwalPendaftaran  $jadwalPendaftaran
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, JadwalPendaftaran $jadwalPendaftaran)
    {
        return $user->can('update akademik');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JadwalPendaftaran  $jadwalPendaftaran
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, JadwalPendaftaran $jadwalPendaftaran)
    {
        return $user->can('delete akademik');
    }
}
