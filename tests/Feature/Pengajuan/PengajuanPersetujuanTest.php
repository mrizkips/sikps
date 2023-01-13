<?php

namespace Tests\Feature\Pengajuan;

use App\Models\KpSkripsi;
use App\Models\Mahasiswa;
use App\Models\Pengajuan;
use App\Models\User;
use Database\Seeders\Test\PengajuanSeederTest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PengajuanPersetujuanTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Run seeder before each test
     *
     * @var bool
     */
    protected $seed = true;

    /** @test */
    public function bisa_menerima_proposal_oleh_keuangan()
    {
        $this->seed(PengajuanSeederTest::class);

        $user = $this->createKeuangan();
        $this->actingAs($user);

        $pengajuan = Pengajuan::first();

        $response = $this->post(route('pengajuan.accept', $pengajuan));

        $persetujuan = $pengajuan->persetujuan->where('role_name', 'Keuangan')->first();

        $this->assertEquals('1', $persetujuan->status);
        $response->assertRedirect(route('pengajuan.index'));
        $response->assertSessionHas(['success' => 'Berhasil menerima pengajuan']);
    }

    /** @test */
    public function bisa_menerima_proposal_oleh_prodi()
    {
        $this->seed(PengajuanSeederTest::class);

        $user = $this->createProdi();
        $this->actingAs($user);

        $pengajuan = Pengajuan::first();

        $response = $this->post(route('pengajuan.accept', $pengajuan));

        $persetujuan = $pengajuan->persetujuan->where('role_name', 'Prodi')->first();

        $this->assertEquals('1', $persetujuan->status);
        $response->assertRedirect(route('pengajuan.index'));
        $response->assertSessionHas(['success' => 'Berhasil menerima pengajuan']);
    }

    /** @test */
    public function bisa_menolak_proposal_oleh_keuangan()
    {
        $this->seed(PengajuanSeederTest::class);

        $user = $this->createKeuangan();
        $this->actingAs($user);

        $pengajuan = Pengajuan::first();

        $response = $this->post(route('pengajuan.reject', $pengajuan));

        $persetujuan = $pengajuan->persetujuan->where('role_name', 'Keuangan')->first();

        $this->assertEquals('2', $persetujuan->status);
        $this->assertEquals('3', $pengajuan->fresh()->status);
        $response->assertRedirect(route('pengajuan.index'));
        $response->assertSessionHas(['success' => 'Berhasil menolak pengajuan']);
    }

    /** @test */
    public function bisa_menolak_proposal_oleh_prodi()
    {
        $this->seed(PengajuanSeederTest::class);

        $user = $this->createProdi();
        $this->actingAs($user);

        $pengajuan = Pengajuan::first();

        $response = $this->post(route('pengajuan.reject', $pengajuan));

        $persetujuan = $pengajuan->persetujuan->where('role_name', 'Prodi')->first();

        $this->assertEquals('2', $persetujuan->status);
        $this->assertEquals('2', $pengajuan->fresh()->status);
        $response->assertRedirect(route('pengajuan.index'));
        $response->assertSessionHas(['success' => 'Berhasil menolak pengajuan']);
    }

    /** @test */
    public function bisa_menolak_proposal_oleh_keuangan_dan_menerima_setelah_lunas()
    {
        $this->seed(PengajuanSeederTest::class);

        $user = $this->createKeuangan();
        $this->actingAs($user);

        $pengajuan = Pengajuan::first();

        $this->post(route('pengajuan.reject', $pengajuan));

        $persetujuan = $pengajuan->persetujuan->where('role_name', 'Keuangan')->first();

        $this->assertEquals('2', $persetujuan->status);
        $this->assertEquals('3', $pengajuan->fresh()->status);

        $this->post(route('pengajuan.pay', $pengajuan->fresh()));

        $this->assertEquals('1', $persetujuan->fresh()->status);
        $this->assertEquals('0', $pengajuan->fresh()->status);
    }

    /** @test */
    public function bisa_menerima_proposal_oleh_keuangan_dan_2_oleh_prodi()
    {
        $this->seed(PengajuanSeederTest::class);

        $keuangan = $this->createKeuangan();
        $prodi = $this->createProdi();

        $this->actingAs($keuangan);

        $pengajuan = Pengajuan::first();

        $this->post(route('pengajuan.accept', $pengajuan));
        $persetujuan = $pengajuan->fresh()->persetujuan->where('role_name', 'Keuangan')->first();

        $this->assertEquals('1', $persetujuan->status);
        $this->assertEquals('0', $pengajuan->fresh()->status);

        $this->actingAs($prodi);
        $this->post(route('pengajuan.reject', $pengajuan));
        $persetujuan = $pengajuan->fresh()->persetujuan->where('role_name', 'Prodi')->first();

        $this->assertEquals('2', $persetujuan->status);
        $this->assertEquals('2', $pengajuan->fresh()->status);
    }

    /** @test */
    public function bisa_menolak_proposal_oleh_keuangan_tetapi_1_oleh_prodi()
    {
        $this->seed(PengajuanSeederTest::class);

        $keuangan = $this->createKeuangan();
        $prodi = $this->createProdi();
        $this->actingAs($keuangan);

        $pengajuan = Pengajuan::first();

        $this->post(route('pengajuan.reject', $pengajuan));
        $persetujuan = $pengajuan->fresh()->persetujuan->where('role_name', 'Keuangan')->first();

        $this->assertEquals('2', $persetujuan->status);
        $this->assertEquals('3', $pengajuan->fresh()->status);

        $this->actingAs($prodi);
        $this->post(route('pengajuan.accept', $pengajuan->fresh()));
        $persetujuan = $pengajuan->fresh()->persetujuan->where('role_name', 'Prodi')->first();

        $this->assertEquals('1', $persetujuan->status);
        $this->assertEquals('3', $pengajuan->fresh()->status);
    }

    /** @test */
    public function bisa_menerima_proposal_pengajuan_dan_aktivasi_pengajuan_proposal()
    {
        $this->seed(PengajuanSeederTest::class);

        $keuangan = $this->createKeuangan();
        $prodi = $this->createProdi();

        $this->actingAs($keuangan);

        $pengajuan = Pengajuan::first();

        $this->post(route('pengajuan.accept', $pengajuan));
        $persetujuan = $pengajuan->fresh()->persetujuan->where('role_name', 'Keuangan')->first();

        $this->assertEquals('1', $persetujuan->status);
        $this->assertEquals('0', $pengajuan->fresh()->status);

        $this->actingAs($prodi);
        $this->post(route('pengajuan.accept', $pengajuan->fresh()));
        $persetujuan = $pengajuan->fresh()->persetujuan->where('role_name', 'Prodi')->first();

        $this->assertEquals('1', $persetujuan->status);
        $this->assertEquals('1', $pengajuan->fresh()->status);
    }

    /** @test */
    public function bisa_menambahkan_kp_skripsi()
    {
        $this->seed(PengajuanSeederTest::class);

        $keuangan = $this->createKeuangan();
        $prodi = $this->createProdi();

        $this->actingAs($keuangan);
        $pengajuan = Pengajuan::first();
        $this->post(route('pengajuan.accept', $pengajuan));

        $this->actingAs($prodi);
        $this->post(route('pengajuan.accept', $pengajuan->fresh()));
        $this->assertEquals('1', $pengajuan->fresh()->status);

        $mahasiswa = Mahasiswa::first();
        $this->actingAs($mahasiswa->user);

        $response = $this->post(route('pengajuan.kp_skripsi', $pengajuan));

        $this->assertNotNull(KpSkripsi::all());
        $response->assertRedirect(route('kp_skripsi.index'));
        $response->assertSessionHas(['success' => 'Berhasil menambahkan kp/skripsi']);
    }

    /**
     * Create user keuangan
     *
     * @return User
     */
    private function createKeuangan()
    {
        return User::create([
            'nama' => 'Keuangan',
            'username' => 'keuangan',
            'password' => 'keuangan',
        ])->assignRole('Keuangan');
    }

    /**
     * Create user prodi
     *
     * @return User
     */
    private function createProdi()
    {
        return User::create([
            'nama' => 'Prodi',
            'username' => 'prodi',
            'password' => 'prodi',
        ])->assignRole('Prodi');
    }
}
