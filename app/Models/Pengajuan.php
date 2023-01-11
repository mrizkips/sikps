<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'pengajuan';

    /**
     * Assign guarded fields
     *
     * @var mixed
     */
    protected $guarded = [];

    /**
     * The model's default values for attributes.
     * @var array
     */
    protected $attributes = [
        'status' => '0'
    ];

    /**
     * Cast status attribute
     *
     * @return Attribute
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: function ($status) {
                if ($status == 0) {
                    return 'Menunggu';
                }
                else if ($status == 1) {
                    return 'Diterima';
                }
                else if ($status == 2) {
                    return 'Ditolak';
                }
                else if ($status == 3) {
                    return 'Belum bayar';
                }
                else if ($status == 4) {
                    return 'Aktif';
                }
                else {
                    return null;
                }
            }
        );
    }

    /**
     * This resource path
     *
     * @param mixed $url
     * @return string
     */
    public function path($url = '')
    {
        return '/pengajuan/' . $this->id . $url;
    }

    /**
     * Get mahasiswa related to this resource
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    /**
     * Get jadwal pendaftaran related to this resource
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jadwalPendaftaran()
    {
        return $this->belongsTo(JadwalPendaftaran::class, 'jadwal_pendaftaran_id');
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

    /**
     * Get proposal related to this resource
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proposal()
    {
        return $this->belongsTo(Pengajuan::class, 'proposal_id');
    }

    /**
     * Get persetujuan related to this resource
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function persetujuan()
    {
        return $this->hasMany(Persetujuan::class, 'pengajuan_id');
    }

    /**
     * Cancel pengajuan
     *
     * @return bool
     */
    public function cancel()
    {
        foreach ($this->persetujuan() as $persetujuan) {
            if ($persetujuan->status != null) {
                return false;
            }
        }

        return $this->delete();
    }

    /**
     * Accept pengajuan
     *
     * @return bool
     */
    public function accept()
    {
        if (auth()->user()->hasRole('Keuangan')) {
            $persetujuan = $this->persetujuan->where('role_name', 'Keuangan')->first();
            $persetujuan->accept();
        }

        if (auth()->user()->hasRole('Prodi')) {
            $persetujuan = $this->persetujuan->where('role_name', 'Prodi')->first();
            $persetujuan->accept();
        }

        if ($this->persetujuan->where('status', 'Diterima')->count() == 2) {
            return $this->update(['status' => '1']);
        }

        return false;
    }

    /**
     * Reject pengajuan
     *
     * @return bool
     */
    public function reject()
    {
        if (auth()->user()->hasRole('Keuangan')) {
            $persetujuan = $this->persetujuan->where('role_name', 'Keuangan')->first();
            $persetujuan->reject();
            return $this->update(['status' => '3']);
        }

        if (auth()->user()->hasRole('Prodi')) {
            $persetujuan = $this->persetujuan->where('role_name', 'Prodi')->first();
            $persetujuan->reject();
            return $this->update(['status' => '2']);
        }

        return false;
    }

    /**
     * Pay pengajuan
     *
     * @return bool
     */
    public function pay()
    {
        if (auth()->user()->hasRole('Keuangan')) {
            $persetujuan = $this->persetujuan->where('role_name', 'Keuangan')->first();
            $persetujuan->accept();
        }

        if ($this->persetujuan->where('status', '1')->count() == 2) {
            return $this->update(['status' => '1']);
        }

        return $this->update(['status' => '0']);
    }

    public function kpSkripsi()
    {
        $data = [
            'jenis' => $this->proposal->jenis == 'Kerja Praktek' ? 1 : 2,
            'proposal_id' => $this->proposal_id,
            'mahasiswa_id' => $this->mahasiswa_id,
            'pengajuan_id' => $this->id,
            'tahun_akademik_id' => $this->tahun_akademik_id,
            'jadwal_pendaftaran_id' => $this->jadwal_pendaftaran_id,
        ];

        if (KpSkripsi::create($data)) {
            return $this->update(['status' => '4']);
        }

        return false;
    }

    /**
     * Cek status review pengajuan
     *
     * @return bool
     */
    public function reviewed()
    {
        switch ($this->status) {
            case '1':
                return true;

            case '2':
                return true;

            case '4':
                return true;
        }

        return false;
    }
}
