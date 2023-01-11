<?php

namespace Tests\Feature\Dashboard;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardViewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Run seeder before each test
     *
     * @var bool
     */
    protected $seed = true;

    /** @test */
    public function bisa_mengakses_dashboard()
    {
        $admin = User::first();
        $this->actingAs($admin);

        $response = $this->get(route('dashboard'));
        $response->assertOk();
    }
}
