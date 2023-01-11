<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Proposal extends Model
{
    use HasFactory;

    /**
     * Table name
     *
     * @var mixed
     */
    protected $table = 'proposal';

    /**
     * Assign guarded fields
     *
     * @var mixed
     */
    protected $guarded = [];

    /**
     * This resource path
     *
     * @param mixed $url
     * @return string
     */
    public function path($url = '')
    {
        return '/proposal/' . $this->id . $url;
    }

    /**
     * Cast attribute of jenis
     *
     * @return Attribute
     */
    protected function jenis(): Attribute
    {
        return Attribute::make(
            get: function ($jenis) {
                if ($jenis == 1) {
                    return 'Kerja Praktek';
                }
                else if ($jenis == 2) {
                    return 'Skripsi';
                }
                else {
                    return $jenis;
                }
            }
        );
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
     * Get pengajuan related to this resource
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'proposal_id');
    }

    /**
     * Ajukan proposal
     *
     * @param int $jadwalPendaftaranId
     * @param Mahasiswa|null $mahasiswa
     * @return void
     */
    public function submit($jadwalPendaftaranId, $mahasiswa = null)
    {
        $jadwalPendaftaran = JadwalPendaftaran::find($jadwalPendaftaranId);

        $data = [
            'jenis' => $jadwalPendaftaran->jenis === 'Proposal' ? '1' : ($jadwalPendaftaran->jenis === 'Pra-sidang' ? '2' : '3'),
            'mahasiswa_id' => $mahasiswa->id ?? auth()->user()->mahasiswa->id,
            'tahun_akademik_id' => $jadwalPendaftaran->tahun_akademik_id,
            'jadwal_pendaftaran_id' => $jadwalPendaftaranId
        ];

        DB::transaction(function () use ($data) {
            $pengajuan = $this->pengajuan()->create($data);

            Persetujuan::create(['pengajuan_id' => $pengajuan->id, 'role_name' => 'Keuangan']);
            Persetujuan::create(['pengajuan_id' => $pengajuan->id, 'role_name' => 'Prodi']);
        });
    }
}
