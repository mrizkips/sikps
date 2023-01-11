<?php

namespace App\Policies;

use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PengajuanPolicy
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
        return $user->can('view any pengajuan');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pengajuan  $pengajuan
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Pengajuan $pengajuan)
    {
        if ($user->can('view pengajuan') && !$user->hasRole('Mahasiswa')) {
            return true;
        }

        return $user->mahasiswa->id === $pengajuan->mahasiswa_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        if ($user->hasRole('Mahasiswa')) {
            foreach (Pengajuan::where('mahasiswa_id', $user->mahasiswa->id) as $pengajuan) {
                if (!$pengajuan->reviewed()) {
                    return false;
                }
            }
        }

        return $user->can('create pengajuan');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pengajuan  $pengajuan
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Pengajuan $pengajuan)
    {
        return $user->can('delete pengajuan') && $user->mahasiswa->id === $pengajuan->mahasiswa_id;
    }

    /**
     * Determine whether the user can accept pengajuan.
     *
     * @param User $user
     * @param Pengajuan $pengajuan
     * @return bool
     */
    public function accept(User $user, Pengajuan $pengajuan)
    {
        foreach ($pengajuan->persetujuan as $persetujuan) {
            if ($user->hasRole($persetujuan->role_name) && $persetujuan->status == null) {
                return $user->can('accept pengajuan') && !$pengajuan->reviewed();
            }
        }

        return false;
    }

    /**
     * Determine whether the user can reject pengajuan.
     *
     * @param User $user
     * @param Pengajuan $pengajuan
     * @return bool
     */
    public function reject(User $user, Pengajuan $pengajuan)
    {
        foreach ($pengajuan->persetujuan as $persetujuan) {
            if ($user->hasRole($persetujuan->role_name) && $persetujuan->status == null) {
                return $user->can('reject pengajuan') && !$pengajuan->reviewed();
            }
        }

        return false;
    }

    /**
     * Determine whether the user can acc pembayaran pengajuan.
     *
     * @param User $user
     * @param Pengajuan $pengajuan
     * @return bool
     */
    public function pay(User $user, Pengajuan $pengajuan)
    {
        if ($user->hasRole('Keuangan') && $pengajuan->status == 'Belum bayar') {
            return $user->can('accept pengajuan');
        }

        return false;
    }

    /**
     * Determine whether the user can add kp_skripsi
     *
     * @param User $user
     * @param Pengajuan $pengajuan
     * @return bool
     */
    public function kpSkripsi(User $user, Pengajuan $pengajuan)
    {
        return $user->can('create pengajuan') && $pengajuan->status == 'Diterima';
    }
}
