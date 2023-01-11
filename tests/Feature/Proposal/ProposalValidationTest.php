<?php

namespace Tests\Feature\Proposal;

use App\Models\Mahasiswa;
use Database\Seeders\Test\MahasiswaSeederTest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProposalValidationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Run seeder before each test
     *
     * @var bool
     */
    protected $seed = true;

    /** @test */
    public function judul_harus_diisi()
    {
        $this->seed(MahasiswaSeederTest::class);

        $mahasiswa = Mahasiswa::first();
        $this->actingAs($mahasiswa->user);

        Storage::fake('local');

        $file = UploadedFile::fake()->create('document.pdf', 1024);

        $response = $this->post(route('proposal.store'), [
            'judul' => null,
            'jenis' => 1,
            'file_proposal' => $file,
            'deskripsi' => 'SIKPS untuk STMIK Bandung',
            'organisasi' => 'STMIK Bandung',
        ]);

        $response->assertSessionHasErrors(['judul' => 'judul wajib diisi.']);
    }

    /** @test */
    public function jenis_harus_diisi_dan_tersedia()
    {
        $this->seed(MahasiswaSeederTest::class);

        $mahasiswa = Mahasiswa::first();
        $this->actingAs($mahasiswa->user);

        Storage::fake('local');

        $file = UploadedFile::fake()->create('document.pdf', 1024);

        $response = $this->post(route('proposal.store'), [
            'judul' => 'SIKPS',
            'jenis' => null,
            'file_proposal' => $file,
            'deskripsi' => 'SIKPS untuk STMIK Bandung',
            'organisasi' => 'STMIK Bandung',
        ]);

        $response->assertSessionHasErrors(['jenis' => 'jenis wajib diisi.']);

        $response = $this->post(route('proposal.store'), [
            'judul' => 'SIKPS',
            'jenis' => 0,
            'file_proposal' => $file,
            'deskripsi' => 'SIKPS untuk STMIK Bandung',
            'organisasi' => 'STMIK Bandung',
        ]);

        $response->assertSessionHasErrors(['jenis' => 'jenis yang dipilih tidak valid.']);
    }

    /** @test */
    public function deskripsi_harus_diisi()
    {
        $this->seed(MahasiswaSeederTest::class);

        $mahasiswa = Mahasiswa::first();
        $this->actingAs($mahasiswa->user);

        Storage::fake('local');

        $file = UploadedFile::fake()->create('document.pdf', 1024);

        $response = $this->post(route('proposal.store'), [
            'judul' => 'SIKPS',
            'jenis' => 1,
            'file_proposal' => $file,
            'deskripsi' => null,
            'organisasi' => 'STMIK Bandung',
        ]);

        $response->assertSessionHasErrors(['deskripsi' => 'deskripsi wajib diisi.']);
    }

    /** @test */
    public function organisasi_harus_diisi_jika_jenis_kp()
    {
        $this->seed(MahasiswaSeederTest::class);

        $mahasiswa = Mahasiswa::first();
        $this->actingAs($mahasiswa->user);

        Storage::fake('local');

        $file = UploadedFile::fake()->create('document.pdf', 1024);

        $response = $this->post(route('proposal.store'), [
            'judul' => 'SIKPS',
            'jenis' => 1,
            'file_proposal' => $file,
            'deskripsi' => 'SIKPS STMIK Bandung',
            'organisasi' => null,
        ]);

        $response->assertSessionHasErrors(['organisasi' => 'organisasi harus diisi jika jenis adalah kerja praktek.']);
    }

    /** @test */
    public function file_proposal_harus_diisi_pdf_dan_max_5mb()
    {
        $this->seed(MahasiswaSeederTest::class);

        $mahasiswa = Mahasiswa::first();
        $this->actingAs($mahasiswa->user);

        Storage::fake('local');

        $file = UploadedFile::fake()->create('document.docx', 1024);

        $response = $this->post(route('proposal.store'), [
            'judul' => 'SIKPS',
            'jenis' => 1,
            'file_proposal' => null,
            'deskripsi' => 'SIKPS di STMIK Bandung',
            'organisasi' => 'STMIK Bandung',
        ]);

        $response->assertSessionHasErrors(['file_proposal' => 'file proposal wajib diisi.']);

        $response = $this->post(route('proposal.store'), [
            'judul' => 'SIKPS',
            'jenis' => 1,
            'file_proposal' => $file,
            'deskripsi' => 'SIKPS di STMIK Bandung',
            'organisasi' => 'STMIK Bandung',
        ]);

        $response->assertSessionHasErrors(['file_proposal' => 'file proposal harus berupa berkas berjenis: pdf.']);

        $file = UploadedFile::fake()->create('document.pdf', 10240);

        $response = $this->post(route('proposal.store'), [
            'judul' => 'SIKPS',
            'jenis' => 1,
            'file_proposal' => $file,
            'deskripsi' => 'SIKPS di STMIK Bandung',
            'organisasi' => 'STMIK Bandung',
        ]);

        $response->assertSessionHasErrors(['file_proposal' => 'file proposal maksimal berukuran 5120 kilobita.']);
    }
}
