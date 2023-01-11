<?php

namespace Tests\Feature\Akademik;

use App\Models\JadwalPendaftaran;
use App\Models\TahunAkademik;
use App\Models\User;
use Database\Seeders\Test\TahunAkademikSeederTest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class JadwalPendaftaranCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Run seeder before each test
     *
     * @var bool
     */
    protected $seed = true;

    /** @test */
    public function bisa_menambahkan_jadwal_pendaftaran()
    {
        $this->seed(TahunAkademikSeederTest::class);

        $admin = User::where('username', 'admin')->first();
        $this->actingAs($admin);

        $tahun_akademik = TahunAkademik::first();

        $response = $this->post(route('jadwal_pendaftaran.store'), [
            'judul' => 'Pendaftaran Proposal 2022/2023',
            'jenis' => 1,
            'tgl_pembukaan' => '26-12-2022',
            'tgl_penutupan' => '02-01-2023',
            'semester' => 1,
            'tahun_akademik_id' => $tahun_akademik->id
        ]);

        $jadwalPendaftaran = JadwalPendaftaran::all();

        $this->assertCount(1, $jadwalPendaftaran);
        $this->assertInstanceOf(Carbon::class, $jadwalPendaftaran->first()->tgl_pembukaan);
        $this->assertEquals('2023-01-02', $jadwalPendaftaran->first()->tgl_penutupan->format('Y-m-d'));
        $response->assertRedirect(route('jadwal_pendaftaran.index'));
        $response->assertSessionHas(['success' => 'Berhasil menambahkan jadwal pendaftaran']);
    }

    /** @test */
    public function bisa_mengupdate_jadwal_pendaftaran()
    {
        $this->seed(TahunAkademikSeederTest::class);

        $admin = User::where('username', 'admin')->first();
        $this->actingAs($admin);

        $tahun_akademik = TahunAkademik::first();

        $this->post(route('jadwal_pendaftaran.store'), [
            'judul' => 'Pendaftaran Proposal 2022/2023',
            'jenis' => 1,
            'tgl_pembukaan' => '26-12-2022',
            'tgl_penutupan' => '02-01-2023',
            'semester' => 1,
            'tahun_akademik_id' => $tahun_akademik->id
        ]);

        $jadwalPendaftaran = JadwalPendaftaran::all();

        $this->assertCount(1, $jadwalPendaftaran);

        $response = $this->put($jadwalPendaftaran->first()->path(), [
            'judul' => 'Pendaftaran Proposal 2022/2023',
            'jenis' => 1,
            'tgl_pembukaan' => '01-01-2023',
            'tgl_penutupan' => '31-01-2023',
            'semester' => 2,
            'tahun_akademik_id' => $tahun_akademik->id
        ]);

        $this->assertEquals('1', $jadwalPendaftaran->fresh()->first()->jenis);
        $this->assertEquals('2023/01/01', $jadwalPendaftaran->fresh()->first()->tgl_pembukaan->format('Y/m/d'));
        $this->assertEquals('2023/01/31', $jadwalPendaftaran->fresh()->first()->tgl_penutupan->format('Y/m/d'));
        $this->assertEquals('2', $jadwalPendaftaran->fresh()->first()->semester);
        $response->assertRedirect(route('jadwal_pendaftaran.edit', $jadwalPendaftaran->first()));
        $response->assertSessionHas(['success' => 'Berhasil mengubah jadwal pendaftaran']);
    }

    /** @test */
    public function bisa_menghapus_jadwal_pendaftaran()
    {
        $this->seed(TahunAkademikSeederTest::class);

        $admin = User::where('username', 'admin')->first();
        $this->actingAs($admin);

        $tahun_akademik = TahunAkademik::first();

        $this->post(route('jadwal_pendaftaran.store'), [
            'judul' => 'Pendaftaran Proposal 2022/2023',
            'jenis' => 1,
            'tgl_pembukaan' => '26-12-2022',
            'tgl_penutupan' => '02-01-2023',
            'semester' => 1,
            'tahun_akademik_id' => $tahun_akademik->id
        ]);

        $jadwalPendaftaran = JadwalPendaftaran::all();

        $this->assertCount(1, $jadwalPendaftaran);

        $response = $this->delete($jadwalPendaftaran->first()->path());

        $this->assertCount(0, $jadwalPendaftaran->fresh());
        $response->assertRedirect(route('jadwal_pendaftaran.index'));
        $response->assertSessionHas(['success' => 'Berhasil menghapus jadwal pendaftaran']);
    }
}
