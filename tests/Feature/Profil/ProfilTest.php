<?php

namespace Tests\Feature\Profil;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfilTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Run seeder before each test
     *
     * @var bool
     */
    protected $seed = true;

    /** @test */
    public function bisa_akses_halaman_profil()
    {
        $admin = User::first();
        $this->actingAs($admin);

        $response = $this->get(route('profile.edit'));
        $response->assertOk();
    }

    /** @test */
    public function bisa_mengupdate_profil()
    {
        $admin = User::first();
        $this->actingAs($admin);

        $response = $this->put(route('profile.update'), [
            'nama' => 'Admin',
            'username' => 'admin',
            'jk' => 'L',
            'email' => 'admin@mail.com',
            'no_hp' => '000',
        ]);

        $this->assertEquals('L', $admin->fresh()->jk);
        $this->assertEquals('admin@mail.com', $admin->fresh()->email);
        $this->assertEquals('000', $admin->fresh()->no_hp);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas(['success' => 'Berhasil mengubah profil']);
    }

    /** @test */
    public function bisa_mengubah_password()
    {
        $user = User::create([
            'nama' => 'Test',
            'username' => 'test',
            'password' => 'test',
        ]);

        $user->assignRole('Staff');

        $this->actingAs($user);

        $response = $this->put(route('password.update'), [
            'current_password' => 'test',
            'password' => 'test1234',
            'password_confirmation' => 'test1234',
        ]);

        $this->assertTrue(Hash::check('test1234', $user->fresh()->password));
        $response->assertSessionHas(['success' => 'Berhasil mengubah password']);
    }
}
