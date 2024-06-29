<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_fetch_all_books()
    {
        Book::factory()->count(5)->create();

        $response = $this->getJson('/api/books', [
            'Api-Access-Key' => env('API_KEY'),
        ]);

        $response->assertStatus(200)
            ->assertJsonCount(5);
    }

    public function test_fetch_single_book()
    {
        $book = Book::factory()->create();

        $response = $this->getJson("/api/books/{$book->id}", [
            'Api-Access-Key' => env('API_KEY'),
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $book->id,
                'title' => $book->title,
                'subtitle' => $book->subtitle,
                'publisher' => $book->publisher,
                'description' => $book->description,
            ]);
    }

    public function test_create_book()
    {
        $author = Author::factory()->create();

        $bookData = [
            'title' => 'New Book',
            'subtitle' => 'New Book Subtitle',
            'publisher' => 'New Publisher',
            'description' => 'New Book Description',
            'authors_ids' => [$author->id],
        ];

        $response = $this->postJson('/api/books', $bookData, [
            'Api-Access-Key' => env('API_KEY'),
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'title' => 'New Book',
                'subtitle' => 'New Book Subtitle',
                'publisher' => 'New Publisher',
                'description' => 'New Book Description',
            ])
            ->assertJsonStructure([
                'id',
                'title',
                'subtitle',
                'publisher',
                'description',
                'authors' => [
                    '*' => [
                        'id',
                        'firstname',
                        'lastname',
                    ],
                ],
            ]);

        $this->assertDatabaseHas('books', [
            'title' => 'New Book',
            'subtitle' => 'New Book Subtitle',
            'publisher' => 'New Publisher',
            'description' => 'New Book Description',
        ]);

        $this->assertDatabaseHas('author_book_pivots', [
            'author_id' => $author->id,
            'book_id' => $response['id'],
        ]);

    }

    public function test_update_book()
    {
        $book = Book::factory()->create();
        $author = Author::factory()->create();

        $updatedData = [
            'title' => 'Updated Title',
            'subtitle' => 'Updated Subtitle',
            'publisher' => 'Updated Publisher',
            'description' => 'Updated Description',
            'authors_ids' => [$author->id],
        ];

        $response = $this->putJson("/api/books/{$book->id}", $updatedData, [
            'Api-Access-Key' => env('API_KEY'),
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'title' => 'Updated Title',
                'subtitle' => 'Updated Subtitle',
                'publisher' => 'Updated Publisher',
                'description' => 'Updated Description',
            ])
            ->assertJsonStructure([
                'id',
                'title',
                'subtitle',
                'publisher',
                'description',
                'authors' => [
                    '*' => [
                        'id',
                        'firstname',
                        'lastname',
                    ],
                ],
            ]);

        $this->assertDatabaseHas('books', [
            'title' => 'Updated Title',
            'subtitle' => 'Updated Subtitle',
            'publisher' => 'Updated Publisher',
            'description' => 'Updated Description',
        ]);
        $this->assertDatabaseHas('author_book_pivots', [
            'author_id' => $author->id,
            'book_id' => $book->id,
        ]);
    }

    public function test_delete_book()
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson("/api/books/{$book->id}", [], [
            'Api-Access-Key' => env('API_KEY'),
        ]);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
}
