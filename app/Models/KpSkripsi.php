<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KpSkripsi extends Model
{
    use HasFactory;

    protected $table = 'kp_skripsi';

    protected $guarded = [];

    protected $with = ['mahasiswa', 'tahunAkademik', 'jadwalPendaftaran', 'dosen', 'proposal', 'pengajuan'];

    /**
     * The model's default values for attributes.
     * @var array
     */
    protected $attributes = [
        'form_bimbingan_printed_count' => '0'
    ];

    /**
     * Cast attribute of form bimbingan last printed at
     *
     * @return Attribute
     */
    protected function formBimbinganLastPrintedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value),
            set: fn ($value) => Carbon::parse($value)
        );
    }

    public function getJenis()
    {
        if ($this->jenis == 1) {
            return 'Kerja Praktek';
        }
        else if ($this->jenis == 2) {
            return 'Skripsi';
        }
        else {
            return $this->jenis;
        }
    }

    /**
     * Print form bimbingan update resource
     *
     * @return bool
     */
    public function printFormBimbingan()
    {
        return $this->update([
            'form_bimbingan_printed_count' => $this->form_bimbingan_printed_count + 1,
            'form_bimbingan_last_printed_at' => now(),
        ]);
    }

    public function hasDosenPembimbing()
    {
        return $this->dosen_pembimbing_id !== null;
    }

    public function hasPrintedFormBimbingan()
    {
        return $this->form_bimbingan_printed_count > 0;
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
     * Get proposal related to this resource
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proposal()
    {
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }

    /**
     * Get pengajuan related to this resource
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'pengajuan_id');
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
     * Get jadwal pendaftaran related to this resource
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jadwalPendaftaran()
    {
        return $this->belongsTo(JadwalPendaftaran::class, 'jadwal_pendaftaran_id');
    }

    /**
     * Get dosen related to this resource
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_pembimbing_id');
    }

    public function scopeByMahasiswaId($query, $id)
    {
        $query->where('mahasiswa_id', $id);
    }

    public function scopeByDosenId($query, $id)
    {
        $query->where('dosen_pembimbing_id', $id);
    }

    public function scopeDoesntHaveMentor($query)
    {
        $query->where('dosen_pembimbing_id', null);
    }

    public function scopeByJenis($query, $jenis)
    {
        $query->where('jenis', $jenis);
    }

    public function scopeByStatusNotLulus($query)
    {
        $query->whereHas('pengajuan', function(Builder $query) {
            $query->where('status', '!=', '5');
        });
    }

    public function scopeGroupByJadwalPendaftaranIdAndDosenId($query, $jadwalPendaftaranId = null, $dosenId = null)
    {
        $queryJadwalPendaftaran = $jadwalPendaftaranId != null ? "AND jadwal_pendaftaran_id = $jadwalPendaftaranId" : "";
        $query->select('dosen.nama as dosen',
                DB::raw("(SELECT COUNT(*) AS Jumlah FROM kp_skripsi WHERE jenis = 1
                AND dosen_pembimbing_id = dosen.id
                $queryJadwalPendaftaran
                GROUP BY dosen_pembimbing_id) as total_kp"),
                DB::raw("(SELECT COUNT(*) AS Jumlah FROM kp_skripsi WHERE jenis = 2
                AND dosen_pembimbing_id = dosen.id
                $queryJadwalPendaftaran
                GROUP BY dosen_pembimbing_id) as total_skripsi")
            )
            ->join('dosen', 'kp_skripsi.dosen_pembimbing_id', '=', 'dosen.id')
            ->join('jadwal_pendaftaran', 'kp_skripsi.jadwal_pendaftaran_id', '=', 'jadwal_pendaftaran.id')
            ->when($jadwalPendaftaranId, function ($q, $jadwalPendaftaranId) {
                $q->where('kp_skripsi.jadwal_pendaftaran_id', $jadwalPendaftaranId);
            })
            ->when($dosenId, function ($q, $dosenId) {
                $q->where('dosen_pembimbing_id', $dosenId);
            })
            ->groupBy('dosen.id', 'dosen.nama');
    }

    public function updateJudul($data, $user_id)
    {
        try {
            DB::beginTransaction();

            $proposal = $this->proposal;

            LogPerubahanJudul::create([
                'kp_skripsi_id' => $this->id,
                'judul_lama' => $proposal->judul,
                'judul_baru' => $data['judul'],
                'user_id' => $user_id,
            ]);

            $this->proposal()->update($data);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }

        return true;
    }

    public function graduate()
    {
        $pengajuan = $this->pengajuan;
        return $pengajuan->update([
            'status' => '5'
        ]);
    }
}
