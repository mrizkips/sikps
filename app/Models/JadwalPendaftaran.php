<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class JadwalPendaftaran extends Model
{
    use HasFactory;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'jadwal_pendaftaran';

    /**
     * Assign guarded fields
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Mutate tgl_pembukaan attribute
     *
     * @return Attribute
     */
    protected function tglPembukaan(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value),
            set: fn($value) => Carbon::parse($value)
        );
    }

    /**
     * Mutate tgl_penutupan attribute
     *
     * @return Attribute
     */
    protected function tglPenutupan(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value),
            set: fn($value) => Carbon::parse($value)
        );
    }

    /**
     * Mutate jenis attribute
     *
     * @return string
     */
    public function getJenis()
    {
        if ($this->jenis == 1) {
            return 'Proposal';
        }
        else if ($this->jenis == 2) {
            return 'Pra-sidang';
        }
        else if ($this->jenis == 3) {
            return 'Sidang';
        }
        else {
            return $this->jenis;
        }
    }

    /**
     * Mutate semester attribute
     *
     * @return string
     */
    public function getSemester()
    {
        if ($this->semester == 1) {
            return 'Ganjil';
        }
        else if ($this->semester == 2) {
            return 'Genap';
        }
        else if ($this->semester == 3) {
            return 'Antara';
        }
        else {
            return null;
        }
    }

    /**
     * Get this resource path
     *
     * @param mixed $url
     * @return string
     */
    public function path($url = "")
    {
        return '/jadwal_pendaftaran/' . $this->id . $url;
    }

    /**
     * Get tahun akademik related to this resource
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id');
    }

    public function scopeActive($query)
    {
        $query->where('tgl_pembukaan', '<=', today())
            ->where('tgl_penutupan', '>=', today());
    }
}
