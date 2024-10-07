<?php

namespace Tests\Unit;

use App\Exceptions\NotFoundBookException;
use App\Models\Book;
use App\Repositories\Contracts\BookRepositoryInterface;
use App\Services\BookService;
use App\Services\Contracts\BookServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class BookServiceTest extends TestCase
{
    use RefreshDatabase;

    protected MockInterface $bookRepository;

    protected BookServiceInterface $bookService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bookRepository = Mockery::mock(BookRepositoryInterface::class);
        $this->bookService = new BookService($this->bookRepository);
    }

    public function test_it_can_get_all_books()
    {
        $books = collect([new Book(['id' => 1]), new Book(['id' => 2])]);

        $this->bookRepository->shouldReceive('getAll')
            ->once()
            ->andReturn($books);

        $result = $this->bookService->getAllBooks();
        $this->assertEquals($books, $result);
    }

    public function test_it_can_get_paginated_books()
    {
        $books = collect([new Book(['id' => 1]), new Book(['id' => 2])]);
        $perPage = config('app.per_page');
        $paginator = new LengthAwarePaginator($books, 2, $perPage);

        $this->bookRepository->shouldReceive('paginate')
            ->with($perPage)
            ->once()
            ->andReturn($paginator);

        $result = $this->bookService->getPaginatedBooks($perPage);

        $this->assertEquals($paginator, $result);
    }

    public function test_it_can_get_book_by_id()
    {
        $book = new Book(['id' => 1]);

        $this->bookRepository->shouldReceive('findById')
            ->with(1)
            ->once()
            ->andReturn($book);

        $result = $this->bookService->getBookById(1);

        $this->assertEquals($book, $result);
    }

    public function test_it_throws_exception_when_book_not_found()
    {
        $this->bookRepository->shouldReceive('findById')
            ->with(999)
            ->once()
            ->andReturn(null);

        $this->expectException(NotFoundBookException::class);
        $this->expectExceptionMessage('Book not found');

        $this->bookService->getBookById(999);
    }

    public function test_it_can_create_book()
    {
        $data = ['title' => 'Test Book'];
        $book = new Book($data);

        $this->bookRepository->shouldReceive('create')
            ->with($data)
            ->once()
            ->andReturn($book);

        $result = $this->bookService->createBook($data);

        $this->assertEquals($book, $result);
    }

    public function test_it_can_update_book()
    {
        $book = new Book(['id' => 1, 'title' => 'Old Title']);
        $data = ['title' => 'New Title'];

        $this->bookRepository->shouldReceive('update')
            ->with($book, $data)
            ->once()
            ->andReturn($book);

        $result = $this->bookService->updateBook($book, $data);

        $this->assertEquals($book, $result);
    }

    public function test_it_can_delete_book()
    {
        $book = new Book(['id' => 1]);

        $this->bookRepository->shouldReceive('delete')
            ->with($book)
            ->once()
            ->andReturn(true);

        $this->bookService->deleteBook($book);

        $this->assertTrue(true); // Если исключение не выброшено, тест проходит
    }
}
