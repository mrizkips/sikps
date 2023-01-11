<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * Array of field that should be guarded.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Referencing a path to this resource.
     *
     * @return string
     */
    public function path($url = '')
    {
        return '/users/' . $this->id . $url;
    }

    /**
     * Set password default attribute
     *
     * @param mixed $password
     * @return void
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * Relation with mahasiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class);
    }

    /**
     * Relation with dosen
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function dosen()
    {
        return $this->hasOne(Dosen::class);
    }

    public function getJk()
    {
        if ($this->jk === 'L') {
            return 'Laki-laki';
        } else if ($this->jk === 'P') {
            return 'Perempuan';
        } else {
            return null;
        }
    }
}
