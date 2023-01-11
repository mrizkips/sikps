<?php

namespace Tests\Feature\User;

use App\Models\Dosen;
use App\Models\User;
use Database\Seeders\UserRoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DosenCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Run seeder before each test
     *
     * @var bool
     */
    protected $seed = true;

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
    public function menambahkan_dosen_ke_database()
    {
        $staff = User::create([
            'nama' => 'staff',
            'username' => 'staff',
            'password' => 'staff'
        ]);

        $staff->givePermissionTo('create user');
        $this->actingAs($staff);

        $response = $this->post(route('users.store'), $this->dosen);

        $user = User::where('username', $this->dosen['username'])->first();
        $this->assertTrue($user->hasRole('Dosen'));

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas(['success' => 'Berhasil menambahkan user']);
    }

    /** @test */
    public function bisa_mengupdate_dosen()
    {
        $staff = User::create([
            'nama' => 'staff',
            'username' => 'staff',
            'password' => 'staff'
        ]);

        $staff->givePermissionTo('create user');
        $staff->givePermissionTo('update user');
        $this->actingAs($staff);

        $this->post(route('users.store'), $this->dosen);

        $user = User::where('username', $this->dosen['username'])->first();
        $this->assertTrue($user->hasRole('Dosen'));

        $response = $this->put($user->path(), [
            'nama' => 'Jane',
            'username' => 'jane',
            'jk' => 'P',
            'email' => 'janedoe@mail.com',
            'no_hp' => '081123456789',
            'roles' => ['Dosen'],
            'kd_dosen' => 'JD',
            'nidn' => '0987654321',
            'inisial' => 'JD',
        ]);

        $this->assertEquals('Jane', $user->fresh()->nama);
        $this->assertEquals('jane', $user->fresh()->username);
        $this->assertEquals('P', $user->fresh()->jk);
        $this->assertEquals('janedoe@mail.com', $user->fresh()->email);
        $this->assertEquals('081123456789', $user->fresh()->no_hp);

        $this->assertEquals('Jane', $user->fresh()->dosen->nama);
        $this->assertEquals('JD', $user->fresh()->dosen->kd_dosen);
        $this->assertEquals('0987654321', $user->fresh()->dosen->nidn);
        $this->assertEquals('JD', $user->fresh()->dosen->inisial);
        $this->assertTrue($user->fresh()->hasRole('Dosen'));

        $response->assertRedirect(route('users.edit', $user));
        $response->assertSessionHas(['success' => 'Berhasil mengubah user']);
    }

    /** @test */
    public function bisa_menghapus_user_dan_dosen()
    {
        $staff = User::create([
            'nama' => 'staff',
            'username' => 'staff',
            'password' => 'staff'
        ]);

        $staff->givePermissionTo('create user');
        $staff->givePermissionTo('delete user');
        $this->actingAs($staff);

        $this->post(route('users.store'), $this->dosen);

        $user = User::where('username', $this->dosen['username'])->first();
        $this->assertTrue($user->hasRole('Dosen'));

        $response = $this->delete($user->path());
        $this->assertNull($user->fresh());

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas(['success' => 'Berhasil menghapus user']);
    }
}
