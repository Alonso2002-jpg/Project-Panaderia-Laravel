<?php

namespace Tests\Feature;

class staffControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }

    public function test_index_with_admin()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->get('/staff');
        $response->assertViewIs('staff.index');
        $response->assertStatus(200);
    }


}

