<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Repositories\BookRepository;
use App\Repositories\Contracts\BookRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected BookRepositoryInterface $bookRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bookRepository = new BookRepository;
    }

    public function test_it_can_get_all_books()
    {
        Book::factory()->count(5)->create();

        $books = $this->bookRepository->getAll();

        $this->assertCount(5, $books);
    }

    public function test_it_can_paginate_books()
    {
        Book::factory()->count(20)->create();

        $paginator = $this->bookRepository->paginate(5);

        $this->assertCount(5, $paginator->items());
    }

    public function test_it_can_find_book_by_id()
    {
        $book = Book::factory()->create();

        $foundBook = $this->bookRepository->findById($book->id);

        $this->assertEquals($book->id, $foundBook->id);
    }

    public function test_it_returns_null_if_book_not_found()
    {
        $book = $this->bookRepository->findById(999);

        $this->assertNull($book);
    }

    public function test_it_can_create_book()
    {
        $data = [
            'title' => 'Test Book',
            'publisher' => 'Test Publisher',
            'author' => 'Test Author',
            'genre' => 'Test Genre',
            'publication' => '2023-10-01',
            'words' => 50000,
            'price' => 19.99,
        ];

        $book = $this->bookRepository->create($data);

        $this->assertDatabaseHas('books', $data);
        $this->assertEquals('Test Book', $book->title);
    }

    public function test_it_can_update_book()
    {
        $book = Book::factory()->create();

        $data = ['title' => 'Updated Title'];

        $updatedBook = $this->bookRepository->update($book, $data);

        $this->assertEquals('Updated Title', $updatedBook->title);
        $this->assertDatabaseHas('books', ['id' => $book->id, 'title' => 'Updated Title']);
    }

    public function test_it_can_delete_book()
    {
        $book = Book::factory()->create();

        $this->bookRepository->delete($book);

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
}
