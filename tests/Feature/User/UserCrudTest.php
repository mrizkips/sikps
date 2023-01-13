<?php

namespace Tests\Feature\User;

use App\Models\User;
use Database\Seeders\UserRoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Run seeder before each test
     *
     * @var bool
     */
    protected $seed = true;

    /**
     * Staff data
     *
     * @var array
     */
    protected $staff = [
        'nama' => 'Mochamad Rizki Pratama Suhernawan',
        'username' => 'mrizkips',
        'jk' => 'L',
        'email' => 'mrizkips@stmikbandung.ac.id',
        'no_hp' => '082123456789',
        'roles' => ['Staff']
    ];

    /** @test */
    public function bisa_menambahkan_user()
    {
        $this->withoutExceptionHandling();
        $staff = User::create([
            'nama' => 'staff',
            'username' => 'staff',
            'password' => 'staff'
        ]);

        $staff->givePermissionTo('create user');
        $this->actingAs($staff);

        $response = $this->post(route('users.store'), $this->staff);

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas(['success' => 'Berhasil menambahkan user']);
    }

    /** @test */
    public function bisa_mengupdate_password()
    {
        $staff = User::create([
            'nama' => 'staff',
            'username' => 'staff',
            'password' => 'staff'
        ]);

        $staff->givePermissionTo('create user');
        $staff->givePermissionTo('update user');
        $this->actingAs($staff);

        $this->post(route('users.store'), $this->staff);
        $user = User::where('username', $this->staff['username'])->first();

        $response = $this->put(route('users.update_password', $user), [
            'password' => 'qwerty',
            'password_confirmation' => 'qwerty'
        ]);

        $this->assertTrue(Hash::check('qwerty', $user->fresh()->password));
        $response->assertRedirect(route('users.edit', $user));
        $response->assertSessionHas(['success' => 'Berhasil mengubah password']);
    }

    /** @test */
    public function bisa_mengupdate_user()
    {
        $staff = User::create([
            'nama' => 'staff',
            'username' => 'staff',
            'password' => 'staff'
        ]);

        $staff->givePermissionTo('create user');
        $staff->givePermissionTo('update user');
        $this->actingAs($staff);

        $this->post(route('users.store'), $this->staff);

        $user = User::where('username', $this->staff['username'])->first();
        $this->assertTrue($user->hasRole('Staff'));

        $response = $this->put($user->path(), [
            'nama' => 'Prodi',
            'username' => 'prodi',
            'jk' => '',
            'email' => '',
            'no_hp' => '',
            'roles' => ['Prodi']
        ]);

        $this->assertEquals('Prodi', $user->fresh()->nama);
        $this->assertEquals('prodi', $user->fresh()->username);
        $this->assertEquals('', $user->fresh()->jk);
        $this->assertEquals('', $user->fresh()->email);
        $this->assertEquals('', $user->fresh()->no_hp);
        $this->assertTrue($user->fresh()->hasRole('Prodi'));

        $response->assertRedirect(route('users.edit', $user));
        $response->assertSessionHas(['success' => 'Berhasil mengubah user']);
    }

    /** @test */
    public function bisa_menghapus_user()
    {
        $staff = User::create([
            'nama' => 'staff',
            'username' => 'staff',
            'password' => 'staff'
        ]);

        $staff->givePermissionTo('create user');
        $staff->givePermissionTo('delete user');
        $this->actingAs($staff);

        $this->post(route('users.store'), $this->staff);

        $user = User::where('username', $this->staff['username'])->first();
        $this->assertEquals($this->staff['username'], $user->username);

        $response = $this->delete($user->path());
        $this->assertNull($user->fresh());

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas(['success' => 'Berhasil menghapus user']);
    }
}
