<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => 'testuser@example.com']);
    }

    /** @test */
    public function user_can_login()
    {
        // Criação do usuário sem usar o bcrypt diretamente (o factory lida com isso)
        $user = User::factory()->create([
            'email' => 'testuser@example.com',
            // A senha é gerada pelo UserFactory, então use a mesma senha definida lá.
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password', // Deve corresponder à senha definida no UserFactory
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['access_token']);
    }

    /** @test */
    public function user_can_logout()
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/logout');

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Logged out successfully']);
    }
}
