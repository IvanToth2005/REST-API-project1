<?php

namespace Tests\Unit;

use App\Models\Actors;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActorsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_all_actors()
    {
        Actors::factory()->create(['name' => 'Brad Pitt', 'image' => 'default.png']);

        $response = $this->getJson('/api/actors');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'actors' => [
                    '*' => ['id', 'name', 'image']
                ]
            ])
            ->assertJsonFragment(['name' => 'Brad Pitt']);
    }

    public function test_store_creates_new_actor()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/actors', [
                'name' => 'Leonardo DiCaprio',
                'image' => 'default.png'
            ]);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'Leonardo DiCaprio']);

        $this->assertDatabaseHas('actors', ['name' => 'Leonardo DiCaprio']);
    }

    public function test_update_modifies_actor()
    {
        $actor = Actors::factory()->create(['name' => 'Old Name', 'image' => 'default.png']);

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->patchJson("/api/actors/{$actor->id}", [
                'name' => 'New Name'
            ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'New Name']);

        $this->assertDatabaseHas('actors', [
            'id' => $actor->id,
            'name' => 'New Name'
        ]);
    }

    public function test_delete_removes_actor()
    {
        $actor = Actors::factory()->create(['name' => 'Tom Holland', 'image' => 'default.png']);

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->deleteJson("/api/actors/{$actor->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'actor deleted successfully']);

        $this->assertDatabaseMissing('actors', ['id' => $actor->id]);
    }
}
