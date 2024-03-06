<?php

namespace Tests\Feature;

use App\Models\Provider;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProviderControllerTest extends TestCase
{
    protected function setUp(): void{
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }

    public function text_index() {
        $response = $this->get('/providers');
        $response->assertViewIs('providers.index');
        $response->assertViewHas('providers');
        $response->assertStatus(200);
    }

    public function test_show_view(){
        $provider = Provider::first();
        $response = $this->get('/providers/1', $provider->toArray());
        //$response->assertViewIs('providers.details');
        //$response->assertViewHas('providers', $provider);
    }

    public function test_create_view_admin(){
        $adminUser = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($adminUser)->get('/providers/create');
        $response->assertViewIs('providers.create');
        $response->assertStatus(200);
    }

    public function test_create_view_user(){
        $user = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->get('/providers/create');
        $response->assertRedirectToRoute('home');
        $response->assertStatus(302);
    }

    public function test_create_view_guest(){
        $response = $this->get('/providers/create');
        $response->assertRedirectToRoute('login');
        $response->assertStatus(302);
    }

    public function test_update_view_user(){
        $user = User::factory()->create(['role' => 'user']);
        $provider = Provider::first();
        $response = $this->actingAs($user)->get('/providers/1/edit', $provider->toArray());
        $response->assertRedirectToRoute('home');
        $response->assertStatus(302);
    }

    public function test_update_view_guest(){
        $provider = Provider::first();
        $response = $this->get('/providers/1/edit', $provider->toArray());
        $response->assertRedirectToRoute('login');
        $response->assertStatus(302);
    }

    public function test_delete_user(){
        $user = User::factory()->create(['role' => 'user']);
        $provider = Provider::first();
        $response = $this->actingAs($user)->delete('/providers/' . $provider->id, $provider->toArray());
        $response->assertRedirectToRoute('home');
        $response->assertStatus(302);
    }

    public function test_delete_guest(){
        $provider = Provider::first();
        $response = $this->delete('/providers/' . $provider->id, $provider->toArray());
        $response->assertRedirectToRoute('login');
        $response->assertStatus(302);
    }
}
