<?php

namespace Tests\Feature;

use App\Http\Controllers\ProvidersController;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class ProviderControllerTest extends TestCase
{

    use RefreshDatabase;
    private $providerController;

    protected function setUp(): void{
        parent::setUp();
        $this->providerController = new ProvidersController();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }

    public function test_index() {
        $request = new Request();
        $request->search = null;
        $providers = $this->providerController->index($request);
        $this->assertIsObject($providers);
    }


    public function test_create_view_admin(){
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->get('/providers/create');
        $response->assertOk();
        $response->assertViewIs('providers.create');
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


    public function test_update_admin(){
        $user = User::factory()->create(['role' => 'admin']);
        $provider = Provider::factory()->create();
        $providerUpdated = ['name' => 'Nombre nuevo',
            'nif' => '03480731A', 'telephone' => '602967986', 'isDeleted' => false,];
        $response = $this->actingAs($user)->put('/providers/' . $provider->id, $providerUpdated);
        $this->assertIsObject($provider);
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
