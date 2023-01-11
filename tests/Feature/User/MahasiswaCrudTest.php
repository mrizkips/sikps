<?php

namespace Tests\Feature\User;

use App\Models\Mahasiswa;
use App\Models\User;
use Database\Seeders\UserRoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MahasiswaCrudTest extends TestCase
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

    /** @test */
    public function bisa_menambahkan_mahasiswa()
    {
        $staff = User::create([
            'nama' => 'staff',
            'username' => 'staff',
            'password' => 'staff'
        ]);

        $staff->givePermissionTo('create user');
        $this->actingAs($staff);

        $response = $this->post(route('users.store', $this->mahasiswa));

        $user = User::where('username', $this->mahasiswa['username'])->first();
        $this->assertTrue($user->hasRole('Mahasiswa'));

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas(['success' => 'Berhasil menambahkan user']);
    }

    /** @test */
    public function bisa_mengupdate_mahasiswa()
    {
        $staff = User::create([
            'nama' => 'staff',
            'username' => 'staff',
            'password' => 'staff'
        ]);

        $staff->givePermissionTo('create user');
        $staff->givePermissionTo('update user');
        $this->actingAs($staff);

        $this->post(route('users.store'), $this->mahasiswa);

        $user = User::where('username', $this->mahasiswa['username'])->first();
        $this->assertTrue($user->hasRole('Mahasiswa'));

        $response = $this->put($user->path(), [
            'nama' => 'Jane',
            'username' => 'jane',
            'jk' => 'P',
            'email' => 'janedoe@mail.com',
            'no_hp' => '081123456789',
            'roles' => ['Mahasiswa'],
            'nim' => '1218609',
            'jurusan' => 2,
        ]);

        $this->assertEquals('Jane', $user->fresh()->nama);
        $this->assertEquals('jane', $user->fresh()->username);
        $this->assertEquals('P', $user->fresh()->jk);
        $this->assertEquals('janedoe@mail.com', $user->fresh()->email);
        $this->assertEquals('081123456789', $user->fresh()->no_hp);

        $this->assertEquals('Jane', $user->fresh()->mahasiswa->nama);
        $this->assertEquals('1218609', $user->fresh()->mahasiswa->nim);
        $this->assertEquals('2', $user->fresh()->mahasiswa->jurusan);
        $this->assertTrue($user->fresh()->hasRole('Mahasiswa'));

        $response->assertRedirect(route('users.edit', $user));
        $response->assertSessionHas(['success' => 'Berhasil mengubah user']);
    }

    /** @test */
    public function bisa_mengubah_mahasiswa_menjadi_dosen()
    {
        $staff = User::create([
            'nama' => 'staff',
            'username' => 'staff',
            'password' => 'staff'
        ]);

        $staff->givePermissionTo('create user');
        $staff->givePermissionTo('update user');
        $this->actingAs($staff);

        $this->post(route('users.store'), $this->mahasiswa);

        $user = User::where('username', $this->mahasiswa['username'])->first();
        $this->assertTrue($user->hasRole('Mahasiswa'));

        $response = $this->put($user->path(), [
            'nama' => 'Mochamad Rizki Pratama Suhernawan',
            'username' => 'RP',
            'roles' => ['Dosen'],
            'kd_dosen' => 'RP',
            'nidn' => '1234567890',
            'inisial' => 'RP',
        ]);

        $this->assertEquals('Mochamad Rizki Pratama Suhernawan', $user->fresh()->nama);
        $this->assertEquals('RP', $user->fresh()->username);

        $this->assertEquals('RP', $user->fresh()->dosen->kd_dosen);
        $this->assertEquals('1234567890', $user->fresh()->dosen->nidn);
        $this->assertEquals('RP', $user->fresh()->dosen->inisial);
        $this->assertTrue($user->fresh()->hasRole('Dosen'));

        $response->assertRedirect(route('users.edit', $user));
        $response->assertSessionHas(['success' => 'Berhasil mengubah user']);
    }

    /** @test */
    public function bisa_menghapus_user_dan_mahasiswa()
    {
        $staff = User::create([
            'nama' => 'staff',
            'username' => 'staff',
            'password' => 'staff'
        ]);

        $staff->givePermissionTo('create user');
        $staff->givePermissionTo('delete user');
        $this->actingAs($staff);

        $this->post(route('users.store'), $this->mahasiswa);

        $user = User::where('username', $this->mahasiswa['username'])->first();
        $mahasiswa = $user->mahasiswa;

        $this->assertEquals($this->mahasiswa['nim'], $mahasiswa->nim);

        $response = $this->delete($user->path());
        $this->assertNull($user->fresh());

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas(['success' => 'Berhasil menghapus user']);
    }
}
