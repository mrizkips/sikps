<?php

namespace Tests\Feature\Akademik;

use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TahunAkademikCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Run seeder before each test
     *
     * @var bool
     */
    protected $seed = true;

    /** @test */
    public function bisa_menambahkan_tahun_akademik()
    {
        $admin = User::where('username', 'admin')->first();
        $this->actingAs($admin);

        $response = $this->post(route('tahun_akademik.store'), [
            'tahun_awal' => 2022
        ]);

        $this->assertCount(1, TahunAkademik::all());
        $response->assertRedirect(route('jadwal_pendaftaran.index'));
        $response->assertSessionHas(['success' => 'Berhasil menambahkan tahun akademik']);
    }

    /** @test */
    public function tahun_awal_harus_diisi_numerik_dan_unik()
    {
        $admin = User::where('username', 'admin')->first();
        $this->actingAs($admin);

        $response = $this->post(route('tahun_akademik.store'), [
            'tahun_awal' => null
        ]);
        $response->assertSessionHasErrors(['tahun_awal' => 'tahun akademik wajib diisi.']);

        $response = $this->post(route('tahun_akademik.store'), [
            'tahun_awal' => 'abc'
        ]);
        $response->assertSessionHasErrors(['tahun_awal' => 'tahun akademik harus berupa angka.']);

        $this->post(route('tahun_akademik.store'), [
            'tahun_awal' => 2022
        ]);

        $response = $this->post(route('tahun_akademik.store'), [
            'tahun_awal' => 2022
        ]);

        $response->assertSessionHasErrors(['tahun_awal' => 'tahun akademik sudah ada sebelumnya.']);
    }

    /** @test */
    public function bisa_menghapus_tahun_akademik()
    {
        $admin = User::where('username', 'admin')->first();
        $this->actingAs($admin);

        $this->post(route('tahun_akademik.store'), [
            'tahun_awal' => 2022
        ]);

        $tahun_akademik = TahunAkademik::first();
        $response = $this->delete($tahun_akademik->path());

        $this->assertCount(0, TahunAkademik::all());

        $response->assertRedirect(route('jadwal_pendaftaran.index'));
        $response->assertSessionHas(['success' => 'Berhasil menghapus tahun akademik']);
    }
}
