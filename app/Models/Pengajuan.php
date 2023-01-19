<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    protected $with = ['mahasiswa', 'jadwalPendaftaran', 'tahunAkademik', 'proposal', 'persetujuan'];

    /**
     * The model's default values for attributes.
     * @var array
     */
    protected $attributes = [
        'status' => '0'
    ];

    public function getStatus()
    {
        if ($this->status == 0) {
            return 'Menunggu';
        }
        else if ($this->status == 1) {
            return 'Diterima';
        }
        else if ($this->status == 2) {
            return 'Ditolak';
        }
        else if ($this->status == 3) {
            return 'Belum bayar';
        }
        else if ($this->status == 4) {
            return 'Aktif';
        }
        else {
            return null;
        }
    }

    public function getJenis()
    {
        if ($this->jenis == 1) {
            return 'Proposal';
        }
        else if ($this->jenis == 2) {
            return 'Pra-Sidang';
        }
        else if ($this->jenis == 2) {
            return 'Sidang';
        }
        else {
            return $this->jenis;
        }
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
        return $this->belongsTo(Proposal::class, 'proposal_id');
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
    public function accept($catatan)
    {
        if (auth()->user()->hasRole('Keuangan')) {
            $persetujuan = $this->persetujuan()->roleKeuangan()->first();
            $persetujuan->accept($catatan);
        }

        if (auth()->user()->hasRole('Prodi')) {
            $persetujuan = $this->persetujuan()->roleProdi()->first();
            $persetujuan->accept($catatan);

            Persetujuan::create(['pengajuan_id' => $this->id, 'role_name' => 'Keuangan']);
        }

        if ($this->persetujuan()->statusAccepted()->count() == 2) {
            return $this->updateStatusAccepted();
        }

        return false;
    }

    /**
     * Reject pengajuan
     *
     * @return bool
     */
    public function reject($catatan = null)
    {
        if (auth()->user()->hasRole('Keuangan')) {
            $persetujuan = $this->persetujuan()->roleKeuangan()->first();
            $persetujuan->reject($catatan);
            return $this->updateStatusPending();
        }

        if (auth()->user()->hasRole('Prodi')) {
            $persetujuan = $this->persetujuan()->roleProdi()->first();
            $persetujuan->reject($catatan);
            return $this->updateStatusRejected();
        }

        return false;
    }

    /**
     * Pay pengajuan
     *
     * @return bool
     */
    public function pay($catatan)
    {
        if (auth()->user()->hasRole('Keuangan')) {
            $persetujuan = $this->persetujuan()->roleKeuangan()->first();
            $persetujuan->accept($catatan);
        }

        if ($this->persetujuan()->statusAccepted()->count() == 2) {
            return $this->updateStatusActive();
        }

        return $this->updateStatusWaiting();
    }

    public function activate()
    {
        $data = [
            'jenis' => $this->proposal->jenis,
            'proposal_id' => $this->proposal_id,
            'mahasiswa_id' => $this->mahasiswa_id,
            'pengajuan_id' => $this->id,
            'tahun_akademik_id' => $this->tahun_akademik_id,
            'jadwal_pendaftaran_id' => $this->jadwal_pendaftaran_id,
        ];

        if (KpSkripsi::create($data)) {
            return $this->updateStatusActive();
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

    public function updateStatusWaiting()
    {
        return $this->update(['status' => '0']);
    }

    public function updateStatusAccepted()
    {
        return $this->update(['status' => '1']);
    }

    public function updateStatusRejected()
    {
        return $this->update(['status' => '2']);
    }

    public function updateStatusPending()
    {
        return $this->update(['status' => '3']);
    }

    public function updateStatusActive()
    {
        return $this->update(['status' => '4']);
    }

    public function scopeStatusWaiting($query)
    {
        $query->where('status', '0');
    }

    public function scopeStatusAccepted($query)
    {
        $query->where('status', '1');
    }

    public function scopeStatusRejected($query)
    {
        $query->where('status', '2');
    }

    public function scopeStatusPending($query)
    {
        $query->where('status', '3');
    }

    public function scopeStatusActive($query)
    {
        $query->where('status', '4');
    }

    public function scopePersetujuanKeuangan($query)
    {
        $query->whereHas('persetujuan', function (Builder $builder) {
            $builder->where('role_name', 'Keuangan');
        });
    }

    public function scopePersetujuanProdi($query)
    {
        $query->whereHas('persetujuan', function (Builder $builder) {
            $builder->where('role_name', 'Prodi');
        });
    }

    public function scopeByMahasiswaId($query, $id)
    {
        $query->where('mahasiswa_id', $id);
    }
}
