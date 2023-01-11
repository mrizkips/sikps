<?php

namespace Tests\Feature\Proposal;

use App\Models\Mahasiswa;
use App\Models\Proposal;
use Database\Seeders\Test\MahasiswaSeederTest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProposalCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Run seeder before each test
     *
     * @var bool
     */
    protected $seed = true;

    /** @test */
    public function bisa_menambahkan_proposal()
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
            'deskripsi' => 'SIKPS untuk STMIK Bandung',
            'organisasi' => 'STMIK Bandung',
        ]);

        $proposal = Proposal::all();

        $this->assertCount(1, $proposal);
        $this->assertFileEquals($file, Storage::disk('local')->path($proposal->first()->file_proposal));
        $response->assertRedirect(route('proposal.index'));
        $response->assertSessionHas(['success' => 'Berhasil menambahkan proposal']);
    }

    /** @test */
    public function bisa_mengupdate_proposal()
    {
        $this->seed(MahasiswaSeederTest::class);

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

        $proposal = Proposal::all();

        $this->assertCount(1, $proposal);
        $this->assertFileEquals($file, Storage::disk('local')->path($proposal->first()->file_proposal));

        $new_file = UploadedFile::fake()->create('updated_document.pdf', 100);

        $response = $this->put($proposal->first()->path(), [
            'judul' => 'Sistem Informasi KP & Skripsi',
            'jenis' => 2,
            'file_proposal' => $new_file,
            'deskripsi' => 'SIKPS untuk STMIK Bandung',
            'organisasi' => 'STMIK Bandung',
        ]);

        $this->assertFileDoesNotExist(Storage::disk('local')->path($proposal->first()->file_proposal));
        $this->assertFileEquals($new_file, Storage::disk('local')->path($proposal->fresh()->first()->file_proposal));

        $response->assertRedirect(route('proposal.edit', $proposal->first()));
        $response->assertSessionHas(['success' => 'Berhasil mengubah proposal']);
    }

    /** @test */
    public function bisa_menghapus_proposal()
    {
        $this->seed(MahasiswaSeederTest::class);

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

        $proposal = Proposal::all();

        $this->assertCount(1, $proposal);
        $this->assertFileEquals($file, Storage::disk('local')->path($proposal->first()->file_proposal));

        $response = $this->delete($proposal->first()->path());

        $this->assertCount(0, $proposal->fresh());
        $this->assertFileDoesNotExist(Storage::disk('local')->path($proposal->first()->file_proposal));

        $response->assertRedirect(route('proposal.index'));
        $response->assertSessionHas(['success' => 'Berhasil menghapus proposal']);
    }
}
