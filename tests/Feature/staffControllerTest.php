<?php

namespace Tests\Feature;

use App\Models\staff;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class staffControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }

    public function test_create_view_user()
    {
        $user = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->get('/staff/create');
        $response->assertRedirectToRoute('home');
        $response->assertStatus(302);
    }

    public function test_create_view_guest()
    {
        $response = $this->get('/staff/create');
        $response->assertRedirectToRoute('login');
        $response->assertStatus(302);
    }

    public function test_create_view_admin()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($adminUser)->get('/staff/create');
        $response->assertViewIs('staff.create');
        $response->assertStatus(200);
    }

    public function test_index()
    {
        $response = $this->get('/staff');
        $response->assertViewIs('staff.index');
        $response->assertViewHas('staff');
        $response->assertStatus(200);
    }

    public function test_show_view()
    {
        $user = User::factory()->create();
        $staff = Staff::factory()->create();

        $response = $this->actingAs($user)->get('/staff/' . $staff->uuid);
        $response->assertViewIs('staff.show');
        $response->assertViewHas('staff');
        $response->assertStatus(200);
    }

    public function test_update_view_user()
    {
        $user = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->get('/staff/1/edit');
        $response->assertRedirectToRoute('home');
        $response->assertStatus(302);
    }

    public function test_access_create_view_as_guest()
    {
        $response = $this->get('/staff/create');
        $response->assertStatus(302);
    }

    public function test_access_create_view_as_user()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/staff/create');
        $response->assertStatus(200);
    }

    public function test_access_index_as_guest()
    {
        $response = $this->get('/staff');
        $response->assertStatus(200);
    }

    public function test_access_show_view()
    {
        $response = $this->get('/staff/1');
        $response->assertStatus(200);
    }

    public function test_access_edit_view_as_guest()
    {
        $response = $this->get('/staff/1/edit');
        $response->assertStatus(302);
    }

    public function test_access_edit_view_as_user()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/staff/1/edit');
        $response->assertStatus(200);
    }
    
}
