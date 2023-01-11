<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAkademik extends Model
{
    use HasFactory;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'tahun_akademik';

    /**
     * Array of guarded fields
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Indicates model should be timestamped
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * This resource path
     *
     * @param mixed $url
     * @return string
     */
    public function path($url = '')
    {
        return '/tahun_akademik/' . $this->id . $url;
    }

    /**
     * Get jadwal pendaftaran related to this resource
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function jadwalPendaftaran()
    {
        return $this->hasOne(JadwalPendaftaran::class, 'tahun_akademik_id');
    }
}
