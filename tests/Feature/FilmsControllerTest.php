<?php

namespace Tests\Unit;

use App\Models\Films;
use App\Models\Types;
use App\Models\Directors;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilmsControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Types::factory()->create(['id' => 1, 'name' => 'Movie']);
        Directors::factory()->create(['id' => 1, 'name' => 'Test Director']);
    }

    public function test_index_returns_all_films()
    {
        Films::factory()->create(['title' => 'Avatar', 'type_id' => 1, 'director_id' => 1, 'length' => 150]);
        Films::factory()->create(['title' => 'Inception', 'type_id' => 1, 'director_id' => 1, 'length' => 148]);

        $response = $this->getJson('/api/films');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'films' => [
                    '*' => ['id', 'title', 'release_date', 'description', 'length']
                ]
            ])
            ->assertJsonFragment(['title' => 'Avatar'])
            ->assertJsonFragment(['title' => 'Inception']);
    }

    public function test_store_creates_new_film()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/films', [
                'title' => 'Interstellar',
                'type_id' => 1,
                'director_id' => 1,
                'description' => 'Some description that is long enough',
                'length' => 120, // javítva: length, nem lenght
                'release_date' => now()->format('Y-m-d'),
                'image' => 'default.png',
            ]);

        $response->assertStatus(201)
            ->assertJsonFragment(['title' => 'Interstellar']);

        $this->assertDatabaseHas('films', ['title' => 'Interstellar']);
    }

    public function test_update_modifies_existing_film()
    {
        $film = Films::factory()->create([
            'title' => 'Old Title',
            'type_id' => 1,
            'director_id' => 1,
            'length' => 140
        ]);

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->patchJson("/api/films/{$film->id}", [
                'title' => 'New Title'
            ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'New Title']);

        $this->assertDatabaseHas('films', [
            'id' => $film->id,
            'title' => 'New Title'
        ]);
    }

    public function test_delete_removes_film()
    {
        $film = Films::factory()->create([
            'title' => 'To Be Deleted',
            'type_id' => 1,
            'director_id' => 1,
            'length' => 130
        ]);

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->deleteJson("/api/films/{$film->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Film deleted successfully']);

        $this->assertDatabaseMissing('films', ['id' => $film->id]);
    }
}
