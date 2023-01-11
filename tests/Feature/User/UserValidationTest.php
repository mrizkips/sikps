<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserValidationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Run seeder before each test
     *
     * @var bool
     */
    protected $seed = true;

    /**
     * Data for mahasiswa
     *
     * @var array
     */
    protected $mahasiswa = [
        'nama' => 'Mochamad Rizki Pratama Suhernawan',
        'username' => '3218609',
        'jk' => 'L',
        'email' => 'rizki@mail.com',
        'no_hp' => '082123456789',
        'roles' => ['Mahasiswa'],
        'nim' => '3218609',
        'jurusan' => 1,
    ];

    /**
     * Data for dosen
     *
     * @var array
     */
    protected $dosen = [
        'nama' => 'Mochamad Rizki Pratama Suhernawan',
        'username' => 'RP',
        'jk' => 'L',
        'email' => 'mrizkips@stmikbandung.ac.id',
        'no_hp' => '082123456789',
        'roles' => ['Dosen'],
        'kd_dosen' => 'RP',
        'nidn' => '123456789',
        'inisial' => 'RP',
    ];

    /** @test */
    public function nama_harus_diisi()
    {
        $staff = User::create([
            'nama' => 'staff',
            'username' => 'staff',
            'password' => 'staff'
        ]);

        $staff->assignRole('staff');
        $this->actingAs($staff);

        $data = $this->mahasiswa;
        $data['nama'] = '';

        $response = $this->post(route('users.store'), $data);
        $response->assertSessionHasErrors('nama');
    }

    /** @test */
    public function username_harus_diisi_dan_unik()
    {
        $staff = User::create([
            'nama' => 'staff',
            'username' => 'staff',
            'password' => 'staff'
        ]);

        $staff->assignRole('staff');
        $this->actingAs($staff);

        $data = $this->mahasiswa;
        $data['username'] = '';

        $response = $this->post(route('users.store'), $data);
        $response->assertSessionHasErrors('username');

        $response = $this->post(route('users.store'), $this->mahasiswa);
        $response = $this->post(route('users.store'), $this->mahasiswa);
        $response->assertSessionHasErrors('username');
    }

    /** @test */
    public function pilihan_jk_harus_tersedia()
    {
        $staff = User::create([
            'nama' => 'staff',
            'username' => 'staff',
            'password' => 'staff'
        ]);

        $staff->assignRole('staff');
        $this->actingAs($staff);

        $data = $this->mahasiswa;
        $data['jk'] = 'Laki-laki';

        $response = $this->post(route('users.store'), $data);
        $response->assertSessionHasErrors('jk');
    }

    /** @test */
    public function no_hp_harus_numeric_dan_max_15_digit()
    {
        $staff = User::create([
            'nama' => 'staff',
            'username' => 'staff',
            'password' => 'staff'
        ]);

        $staff->assignRole('staff');
        $this->actingAs($staff);

        $data = $this->mahasiswa;
        $data['no_hp'] = 'asdfji';

        $response = $this->post(route('users.store'), $data);
        $response->assertSessionHasErrors('no_hp');

        $data['no_hp'] = '0123456789012345';

        $response = $this->post(route('users.store'), $data);
        $response->assertSessionHasErrors('no_hp');
    }

    /** @test */
    public function pilihan_peran_harus_diisi_tersedia()
    {
        $staff = User::create([
            'nama' => 'staff',
            'username' => 'staff',
            'password' => 'staff'
        ]);

        $staff->assignRole('staff');
        $this->actingAs($staff);

        $data = $this->mahasiswa;
        $data['roles'] = [];

        $response = $this->post(route('users.store'), $data);
        $response->assertSessionHasErrors('roles');

        $data['roles'] = ['Badut'];

        $response = $this->post(route('users.store'), $data);
        $response->assertSessionHasErrors('roles.*');
    }

    /** @test */
    public function nim_harus_diisi_unik_dan_harus_7_digit()
    {
        $staff = User::create([
            'nama' => 'staff',
            'username' => 'staff',
            'password' => 'staff'
        ]);

        $staff->assignRole('staff');
        $this->actingAs($staff);

        $data = $this->mahasiswa;
        $data['nim'] = '';

        $response = $this->post(route('users.store'), $data);
        $response->assertSessionHasErrors('nim');

        $data['nim'] = '12345678';

        $response = $this->post(route('users.store'), $data);
        $response->assertSessionHasErrors('nim');

        $response = $this->post(route('users.store'), $this->mahasiswa);
        $response = $this->post(route('users.store'), $this->mahasiswa);
        $response->assertSessionHasErrors('nim');
    }

    /** @test */
    public function jurusan_harus_diisi_dan_tersedia()
    {
        $staff = User::create([
            'nama' => 'staff',
            'username' => 'staff',
            'password' => 'staff'
        ]);

        $staff->assignRole('staff');
        $this->actingAs($staff);

        $data = $this->mahasiswa;
        $data['jurusan'] = null;
        $response = $this->post(route('users.store'), $data);
        $response->assertSessionHasErrors('jurusan');

        $data['jurusan'] = 3;
        $response = $this->post(route('users.store'), $data);
        $response->assertSessionHasErrors('jurusan');
    }

    /** @test */
    public function kd_dosen_harus_diisi_unik_dan_max_5_karakter()
    {
        $staff = User::create([
            'nama' => 'staff',
            'username' => 'staff',
            'password' => 'staff'
        ]);

        $staff->assignRole('staff');
        $this->actingAs($staff);

        $data = $this->dosen;
        $data['kd_dosen'] = '';

        $response = $this->post(route('users.store'), $data);
        $response->assertSessionHasErrors('kd_dosen');

        $data['kd_dosen'] = '123456';

        $response = $this->post(route('users.store'), $data);
        $response->assertSessionHasErrors('kd_dosen');

        $data['kd_dosen'] = 'RP';

        $this->post(route('users.store'), $data);
        $response = $this->post(route('users.store'), $data);
        $response->assertSessionHasErrors('kd_dosen');
    }

    /** @test */
    public function inisial_harus_diisi_unik_dan_max_5_karakter()
    {
        $staff = User::create([
            'nama' => 'staff',
            'username' => 'staff',
            'password' => 'staff'
        ]);

        $staff->assignRole('staff');
        $this->actingAs($staff);

        $data = $this->dosen;
        $data['inisial'] = '';

        $response = $this->post(route('users.store'), $data);
        $response->assertSessionHasErrors('inisial');

        $data['inisial'] = 'MRIZKIPS';

        $response = $this->post(route('users.store'), $data);
        $response->assertSessionHasErrors('inisial');

        $data['inisial'] = 'RP';

        $this->post(route('users.store'), $data);
        $response = $this->post(route('users.store'), $data);
        $response->assertSessionHasErrors('inisial');
    }

    /** @test */
    public function nidn_harus_unik()
    {
        $staff = User::create([
            'nama' => 'staff',
            'username' => 'staff',
            'password' => 'staff'
        ]);

        $staff->assignRole('staff');
        $this->actingAs($staff);

        $this->post(route('users.store'), $this->dosen);
        $response = $this->post(route('users.store'), $this->dosen);
        $response->assertSessionHasErrors('nidn');
    }
}
