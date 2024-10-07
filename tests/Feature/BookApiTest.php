<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_paginated_books()
    {
        Book::factory()->count(50)->create();

        $response = $this->getJson('/api/books?per_page=10');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'links',
                'meta',
            ]);

        $this->assertCount(10, $response->json('data'));
    }

    public function test_can_show_book()
    {
        $book = Book::factory()->create();
        $response = $this->getJson('/api/books/'.$book->id);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $book->id,
                    'title' => $book->title,
                    'publisher' => $book->publisher,
                    'author' => $book->author,
                    'genre' => $book->genre,
                    'publication' => $book->publication->format('Y-m-d'),
                    'words' => $book->words,
                    'price' => $book->price,
                ],
            ]);
    }

    public function test_it_returns_404_if_book_not_found()
    {
        $response = $this->getJson('/api/books/100500');
        $response->assertStatus(404)
            ->assertJson([
                'error' => 'Book not found',
            ]);
    }

    public function test_can_create_book()
    {
        $data = [
            'title' => 'Sample Book',
            'publisher' => 'Sample Publisher',
            'author' => 'John Doe',
            'genre' => 'Fiction',
            'publication' => '2023-10-01',
            'words' => 50000,
            'price' => 19.99,
        ];

        $response = $this->postJson('/api/books', $data);

        $response->assertStatus(201)
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('books', $data);
    }

    public function test_it_can_update_a_book()
    {
        $book = Book::factory()->create();
        $data = [
            'title' => 'Updated Title',
            'price' => 29.99,
        ];

        $response = $this->patchJson('/api/books/'.$book->id, $data);
        $response->assertStatus(200)
            ->assertJsonFragment($data);
        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Updated Title',
            'price' => 29.99,
        ]);
    }

    public function test_it_validates_fields_when_updating_a_book()
    {
        $book = Book::factory()->create();
        $data = [
            'price' => 'invalid',
        ];
        $response = $this->patchJson('/api/books/'.$book->id, $data);
        $response->assertStatus(422)
            ->assertJsonStructure([
                'errors'
            ]);
    }

    public function test_it_returns_404_when_updating_non_existing_book()
    {
        $data = [
            'title' => 'Updated Title',
        ];
        $response = $this->patchJson('/api/books/100500', $data);
        $response->assertStatus(404)
            ->assertJson([
                'error' => 'Book not found',
            ]);
    }

    public function test_it_can_delete_a_book()
    {
        $book = Book::factory()->create();
        $response = $this->deleteJson('/api/books/'.$book->id);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    public function test_it_returns_404_non_existing_book()
    {
        $response = $this->deleteJson('/api/books/100500');
        $response->assertStatus(404)
            ->assertJson([
                'error' => 'Book not found',
            ]);
    }
}
