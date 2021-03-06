<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'email', 'password', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the role on a certain user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    /**
     * Get mahasiswa on a certain user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class);
    }

    /**
     * Get mahasiswa on a certain user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function dosen()
    {
        return $this->hasOne(Dosen::class);
    }

    /**
     * Get mahasiswa on a certain user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function keuangan()
    {
        return $this->hasOne(Keuangan::class);
    }

    /**
     * Get mahasiswa on a certain user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function baak()
    {
        return $this->hasOne(Baak::class);
    }
}
