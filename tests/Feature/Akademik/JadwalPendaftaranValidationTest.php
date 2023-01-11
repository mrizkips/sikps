<?php

namespace Tests\Feature\Akademik;

use App\Models\TahunAkademik;
use App\Models\User;
use Database\Seeders\Test\TahunAkademikSeederTest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JadwalPendaftaranValidationTest extends TestCase
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
        $this->seed(TahunAkademikSeederTest::class);

        $admin = User::where('username', 'admin')->first();
        $this->actingAs($admin);

        $tahun_akademik = TahunAkademik::first();

        $response = $this->post(route('jadwal_pendaftaran.store'), [
            'judul' => null,
            'jenis' => 1,
            'tgl_pembukaan' => '26-12-2022',
            'tgl_penutupan' => '02-01-2023',
            'semester' => 1,
            'tahun_akademik_id' => $tahun_akademik->id
        ]);

        $response->assertSessionHasErrors(['judul' => 'judul wajib diisi.']);
    }

    /** @test */
    public function jenis_harus_diisi_dan_tersedia()
    {
        $this->seed(TahunAkademikSeederTest::class);

        $admin = User::where('username', 'admin')->first();
        $this->actingAs($admin);

        $tahun_akademik = TahunAkademik::first();

        $response = $this->post(route('jadwal_pendaftaran.store'), [
            'judul' => 'Pendaftaran Proposal 2022/2023',
            'jenis' => null,
            'tgl_pembukaan' => '26-12-2022',
            'tgl_penutupan' => '02-01-2023',
            'semester' => 1,
            'tahun_akademik_id' => $tahun_akademik->id
        ]);

        $response->assertSessionHasErrors(['jenis' => 'jenis wajib diisi.']);

        $response = $this->post(route('jadwal_pendaftaran.store'), [
            'judul' => 'Pendaftaran Proposal 2022/2023',
            'jenis' => 0,
            'tgl_pembukaan' => '26-12-2022',
            'tgl_penutupan' => '02-01-2023',
            'semester' => 1,
            'tahun_akademik_id' => $tahun_akademik->id
        ]);

        $response->assertSessionHasErrors(['jenis' => 'jenis yang dipilih tidak valid.']);
    }

    /** @test */
    public function tgl_pembukaan_harus_diisi_dan_tanggal()
    {
        $this->seed(TahunAkademikSeederTest::class);

        $admin = User::where('username', 'admin')->first();
        $this->actingAs($admin);

        $tahun_akademik = TahunAkademik::first();

        $response = $this->post(route('jadwal_pendaftaran.store'), [
            'judul' => 'Pendaftaran Proposal 2022/2023',
            'jenis' => 1,
            'tgl_pembukaan' => null,
            'tgl_penutupan' => '02-01-2023',
            'semester' => 1,
            'tahun_akademik_id' => $tahun_akademik->id
        ]);

        $response->assertSessionHasErrors(['tgl_pembukaan' => 'tanggal pembukaan wajib diisi.']);

        $response = $this->post(route('jadwal_pendaftaran.store'), [
            'judul' => 'Pendaftaran Proposal 2022/2023',
            'jenis' => 0,
            'tgl_pembukaan' => '26 12 2022',
            'tgl_penutupan' => '02-01-2023',
            'semester' => 1,
            'tahun_akademik_id' => $tahun_akademik->id
        ]);

        $response->assertSessionHasErrors(['tgl_pembukaan' => 'tanggal pembukaan bukan tanggal yang valid.']);
    }

    /** @test */
    public function tgl_penutupan_harus_diisi_tanggal_dan_lebih_besar_atau_sama_dengan_tgl_pembukaan()
    {
        $this->seed(TahunAkademikSeederTest::class);

        $admin = User::where('username', 'admin')->first();
        $this->actingAs($admin);

        $tahun_akademik = TahunAkademik::first();

        $response = $this->post(route('jadwal_pendaftaran.store'), [
            'judul' => 'Pendaftaran Proposal 2022/2023',
            'jenis' => 1,
            'tgl_pembukaan' => '26-12-2022',
            'tgl_penutupan' => null,
            'semester' => 1,
            'tahun_akademik_id' => $tahun_akademik->id
        ]);

        $response->assertSessionHasErrors(['tgl_penutupan' => 'tanggal penutupan wajib diisi.']);

        $response = $this->post(route('jadwal_pendaftaran.store'), [
            'judul' => 'Pendaftaran Proposal 2022/2023',
            'jenis' => 0,
            'tgl_pembukaan' => '26-12-2022',
            'tgl_penutupan' => '02#01#2023',
            'semester' => 1,
            'tahun_akademik_id' => $tahun_akademik->id
        ]);

        $response->assertSessionHasErrors(['tgl_penutupan' => 'tanggal penutupan bukan tanggal yang valid.']);

        $response = $this->post(route('jadwal_pendaftaran.store'), [
            'judul' => 'Pendaftaran Proposal 2022/2023',
            'jenis' => 0,
            'tgl_pembukaan' => '26-12-2022',
            'tgl_penutupan' => '25-12-2022',
            'semester' => 1,
            'tahun_akademik_id' => $tahun_akademik->id
        ]);

        $response->assertSessionHasErrors(['tgl_penutupan' => 'tanggal penutupan harus berisi tanggal setelah atau sama dengan tanggal pembukaan.']);
    }

    /** @test */
    public function semester_harus_diisi_tanggal_dan_tersedia()
    {
        $this->seed(TahunAkademikSeederTest::class);

        $admin = User::where('username', 'admin')->first();
        $this->actingAs($admin);

        $tahun_akademik = TahunAkademik::first();

        $response = $this->post(route('jadwal_pendaftaran.store'), [
            'judul' => 'Pendaftaran Proposal 2022/2023',
            'jenis' => 1,
            'tgl_pembukaan' => '26-12-2022',
            'tgl_penutupan' => '02-12-2022',
            'semester' => null,
            'tahun_akademik_id' => $tahun_akademik->id
        ]);

        $response->assertSessionHasErrors(['semester' => 'semester wajib diisi.']);

        $response = $this->post(route('jadwal_pendaftaran.store'), [
            'judul' => 'Pendaftaran Proposal 2022/2023',
            'jenis' => 0,
            'tgl_pembukaan' => '26-12-2022',
            'tgl_penutupan' => '02-01-2023',
            'semester' => 0,
            'tahun_akademik_id' => $tahun_akademik->id
        ]);

        $response->assertSessionHasErrors(['semester' => 'semester yang dipilih tidak valid.']);
    }

    /** @test */
    public function tahun_akademik_id_harus_diisi_dan_tersedia_di_tabel_tahun_akademik()
    {
        $this->seed(TahunAkademikSeederTest::class);

        $admin = User::where('username', 'admin')->first();
        $this->actingAs($admin);

        $tahun_akademik = TahunAkademik::first();

        $response = $this->post(route('jadwal_pendaftaran.store'), [
            'judul' => 'Pendaftaran Proposal 2022/2023',
            'jenis' => 1,
            'tgl_pembukaan' => '26-12-2022',
            'tgl_penutupan' => '02-12-2022',
            'semester' => 1,
            'tahun_akademik_id' => null
        ]);

        $response->assertSessionHasErrors(['tahun_akademik_id' => 'tahun akademik wajib diisi.']);

        $response = $this->post(route('jadwal_pendaftaran.store'), [
            'judul' => 'Pendaftaran Proposal 2022/2023',
            'jenis' => 0,
            'tgl_pembukaan' => '26-12-2022',
            'tgl_penutupan' => '02-01-2023',
            'semester' => 1,
            'tahun_akademik_id' => 0
        ]);

        $response->assertSessionHasErrors(['tahun_akademik_id' => 'tahun akademik yang dipilih tidak valid.']);
    }
}
