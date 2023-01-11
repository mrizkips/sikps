<?php

namespace Tests\Feature\KpSkripsi;

use App\Models\Dosen;
use App\Models\KpSkripsi;
use App\Models\User;
use Database\Seeders\Test\KpSkripsiSeederTest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KpSkripsiFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Run seeder before each test
     *
     * @var bool
     */
    protected $seed = true;

    /** @test */
    public function bisa_mengubah_dosen_pembimbing_kp_skripsi()
    {
        $this->seed(KpSkripsiSeederTest::class);

        $admin = User::where('username', 'admin')->first();
        $this->actingAs($admin);

        $kpSkripsi = KpSkripsi::first();

        $response = $this->post(route('kp_skripsi.assign_dosen', $kpSkripsi), [
            'dosen_pembimbing_id' => 1,
        ]);

        $this->assertEquals(1, KpSkripsi::first()->dosen_pembimbing_id);
        $response->assertRedirect(route('kp_skripsi.index'));
        $response->assertSessionHas(['success' => 'Berhasil menentukan dosen pembimbing']);
    }

    /** @test */
    public function bisa_mencetak_form_bimbingan()
    {
        $this->seed(KpSkripsiSeederTest::class);

        $admin = User::where('username', 'admin')->first();
        $this->actingAs($admin);

        $kpSkripsi = KpSkripsi::first();
        $dosen = Dosen::first();

        $this->post(route('kp_skripsi.assign_dosen', $kpSkripsi), [
            'dosen_pembimbing_id' => $dosen->id,
        ]);

        $this->assertEquals($dosen->id, KpSkripsi::first()->dosen_pembimbing_id);

        $response = $this->post(route('kp_skripsi.print_form_bimbingan', $kpSkripsi));

        $this->assertEquals(1, $kpSkripsi->fresh()->form_bimbingan_printed_count);
        $response->assertHeader('content-type', 'application/pdf');
    }
}
