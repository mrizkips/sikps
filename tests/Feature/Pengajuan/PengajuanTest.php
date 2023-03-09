<?php

namespace Tests\Feature\Pengajuan;

use App\Models\JadwalPendaftaran;
use App\Models\Mahasiswa;
use App\Models\Pengajuan;
use App\Models\Persetujuan;
use App\Models\Proposal;
use Database\Seeders\Test\JadwalPendaftaranSeederTest;
use Database\Seeders\Test\MahasiswaSeederTest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PengajuanTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Run seeder before each test
     *
     * @var bool
     */
    protected $seed = true;

    /** @test */
    public function bisa_menambahkan_pengajuan_proposal()
    {
        $this->seed([JadwalPendaftaranSeederTest::class, MahasiswaSeederTest::class]);

        $mahasiswa = Mahasiswa::first();
        $this->actingAs($mahasiswa->user);

        Storage::fake('local');

        $file = UploadedFile::fake()->create('document.pdf', 1024);

        $this->post(route('proposal.store'), [
            'judul' => 'SIKPS',
            'jenis' => 1,
            'file_proposal' => $file,
            'deskripsi' => 'SIKPS untuk STMIK Bandung',
            'organisasi' => 'STMIK Bandung',
        ]);

        $proposal = Proposal::first();
        $this->assertNotNull($proposal);

        $jadwalPendaftaran = JadwalPendaftaran::first();

        $response = $this->post(route('pengajuan.store'), [
            'proposal_id' => $proposal->id,
            'jadwal_pendaftaran_id' => $jadwalPendaftaran->id,
        ]);

        $this->assertNotNull(Pengajuan::all());
        $this->assertCount(1, Persetujuan::all()); // Persetujuan dari prodi dulu
        $response->assertRedirect(route('pengajuan.index'));
        $response->assertSessionHas(['success' => 'Berhasil menambahkan pengajuan']);
    }

    /** @test */
    public function bisa_menghapus_pengajuan()
    {
        $this->seed([JadwalPendaftaranSeederTest::class, MahasiswaSeederTest::class]);

        $mahasiswa = Mahasiswa::first();
        $this->actingAs($mahasiswa->user);

        Storage::fake('local');

        $file = UploadedFile::fake()->create('document.pdf', 1024);

        $this->post(route('proposal.store'), [
            'judul' => 'SIKPS',
            'jenis' => 1,
            'file_proposal' => $file,
            'deskripsi' => 'SIKPS untuk STMIK Bandung',
            'organisasi' => 'STMIK Bandung',
        ]);

        $proposal = Proposal::first();
        $this->assertNotNull($proposal);

        $jadwalPendaftaran = JadwalPendaftaran::first();

        $this->post(route('pengajuan.store'), [
            'proposal_id' => $proposal->id,
            'jadwal_pendaftaran_id' => $jadwalPendaftaran->id,
        ]);

        $pengajuan = Pengajuan::first();

        $this->assertNotNull($pengajuan);

        $response = $this->delete($pengajuan->path());

        $response->assertRedirect(route('pengajuan.index'));
        $response->assertSessionHas(['success' => 'Berhasil menghapus pengajuan']);
    }
}
