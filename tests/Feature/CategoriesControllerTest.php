<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoriesControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function setUp(): void{
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }

    public function text_index_with_admin(){
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->get('/categories');
        $response->assertRedirectToRoute('home');
        $response->assertStatus(302);
    }
}
