<?php

namespace Tests\Feature;

use App\Http\Controllers\CategoriesController;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Request;

class CategoriesControllerTest extends TestCase
{

    public function setUp(): void{
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }

    public function test_index_with_admin(){
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->get('/categories');
        $response->assertViewIs('categories.index');
        $response->assertStatus(200);
    }

    public function test_index_with_user(){
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/categories');
        $response->assertRedirectToRoute('home');
        $response->assertStatus(302);
    }

    public function test_index_with_guest(){
        $response = $this->get('/categories');
        $response->assertRedirectToRoute('login');
        $response->assertStatus(302);
    }

    public function test_create_view_with_user(){
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/categories/create');
        $response->assertRedirectToRoute('home');
        $response->assertStatus(302);
    }

    public function test_create_view_with_guest(){
        $response = $this->get('/categories/create');
        $response->assertRedirectToRoute('login');
        $response->assertStatus(302);
    }

    public function test_create_with_admin(){
        $user = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->make();
        $response = $this->actingAs($user)->post('/categories', $category->toArray());
        $response->assertRedirect('/categories');
    }

    public function test_create_name_exists(){
        $user = User::factory()->create(['role' => 'admin']);
        $category = Category::first();
        $response = $this->actingAs($user)->post('/categories', $category->toArray());
        $response->assertSessionHasErrors('name');
    }

    public function test_create_name_empty(){
        $user = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->make(['name' => '']);
        $response = $this->actingAs($user)->post('/categories', $category->toArray());
        $response->assertSessionHasErrors('name');
    }

    public function test_update_with_admin(){
        $user = User::factory()->create(['role' => 'admin']);
        $category = Category::first();
        $category->name = "Name new";
        $response = $this->actingAs($user)->put('/categories/1', $category->toArray());
        $response->assertRedirect('/categories');
    }

    public function test_update_view_with_user(){
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/categories/1/edit');
        $response->assertRedirectToRoute('home');
        $response->assertStatus(302);
    }

    public function test_update_view_with_guest(){
        $response = $this->get('/categories/1/edit');
        $response->assertRedirectToRoute('login');
        $response->assertStatus(302);
    }

    public function test_delete_with_user(){
        $user = User::factory()->create(['role' => 'user']);
        $category = Category::first();
        $response = $this->actingAs($user)->delete('/categories/1', $category->toArray());
        $response->assertRedirect('/home');
        $response->assertStatus(302);
    }

    public function test_delete_admin(){
        $user = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();
        $response = $this->actingAs($user)->delete('/categories/' . $category->id);
        $response->assertRedirect('/categories');
    }


}
