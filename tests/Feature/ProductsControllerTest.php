<?php

namespace Tests\Feature;

use App\Http\Controllers\ProductsController;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductsControllerTest extends TestCase{

    protected function setUp(): void{
    parent::setUp();
    $this->artisan('migrate:fresh');
    $this->artisan('db:seed');
}

    public function text_index() {
        $response = $this->get('/products');
        $response->assertViewIs('products.index');
        $response->assertViewHas('products');
        $response->assertStatus(200);
    }

    public function test_create_view_user(){
        $user = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->get('/products/create');
        $response->assertRedirectToRoute('home');
        $response->assertStatus(302);
    }

    public function test_create_view_guest(){
        $response = $this->get('/products/create');
        $response->assertRedirectToRoute('login');
        $response->assertStatus(302);
    }

    public function test_update_view_user(){
        $user = User::factory()->create(['role' => 'user']);
        $product = Product::first();
        $response = $this->actingAs($user)->get('/products/1/edit', $product->toArray());
        $response->assertRedirectToRoute('home');
        $response->assertStatus(302);
    }

    public function test_update_view_guest(){
        $product = Product::first();
        $response = $this->get('/products/1/edit', $product->toArray());
        $response->assertRedirectToRoute('login');
        $response->assertStatus(302);
    }

    public function test_delete_user(){
        $user = User::factory()->create(['role' => 'user']);
        $product = Product::first();
        $response = $this->actingAs($user)->delete('/products/' . $product->id, $product->toArray());
        $response->assertRedirectToRoute('home');
        $response->assertStatus(302);
    }

    public function test_delete_guest(){
        $product = Product::first();
        $response = $this->delete('/products/' . $product->id, $product->toArray());
        $response->assertRedirectToRoute('login');
        $response->assertStatus(302);
    }
}
