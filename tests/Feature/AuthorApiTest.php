<?php

namespace Tests\Feature;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_fetch_all_authors()
    {
        Author::factory()->count(5)->create();

        $response = $this->getJson('/api/authors', [
            'Api-Access-Key' => env('API_KEY'),
        ]);

        $response->assertStatus(200)
            ->assertJsonCount(5);
    }

    public function test_fetch_single_author()
    {
        $author = Author::factory()->create();

        $response = $this->getJson("/api/authors/{$author->id}", [
            'Api-Access-Key' => env('API_KEY'),
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $author->id,
                'firstname' => $author->firstname,
                'lastname' => $author->lastname,
            ]);
    }

    public function test_create_author()
    {
        $authorData = [
            'firstname' => 'New Author',
            'lastname' => 'Test',
        ];

        $response = $this->postJson('/api/authors', $authorData, [
            'Api-Access-Key' => env('API_KEY'),
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'firstname' => 'New Author',
                'lastname' => 'Test',
            ])
            ->assertJsonStructure([
                'id',
                'firstname',
                'lastname',
            ]);

        $this->assertDatabaseHas('authors', [
            'firstname' => 'New Author',
            'lastname' => 'Test',
        ]);
    }

    public function test_update_author()
    {
        $author = Author::factory()->create();

        $updatedData = [
            'firstname' => 'Updated Firstname',
            'lastname' => 'Updated Lastname',
        ];

        $response = $this->putJson("/api/authors/{$author->id}", $updatedData, [
            'Api-Access-Key' => env('API_KEY'),
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'firstname' => 'Updated Firstname',
                'lastname' => 'Updated Lastname',
            ])
            ->assertJsonStructure([
                'id',
                'firstname',
                'lastname',
            ]);

        $this->assertDatabaseHas('authors', [
            'id' => $author->id,
            'firstname' => 'Updated Firstname',
            'lastname' => 'Updated Lastname',
        ]);
    }

    public function test_delete_author()
    {
        $author = Author::factory()->create();

        $response = $this->deleteJson("/api/authors/{$author->id}", [], [
            'Api-Access-Key' => env('API_KEY'),
        ]);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('authors', ['id' => $author->id]);
    }
}

