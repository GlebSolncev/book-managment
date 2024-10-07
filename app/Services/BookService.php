<?php

namespace App\Services;

use App\Exceptions\NotFoundBookException;
use App\Models\Book;
use App\Repositories\Contracts\BookRepositoryInterface;
use App\Services\Contracts\BookServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class BookService implements BookServiceInterface
{
    public function __construct(
        protected BookRepositoryInterface $bookRepository
    ) {}

    public function getAllBooks(): Collection
    {
        return $this->bookRepository->getAll();
    }

    public function getPaginatedBooks(int $perPage): LengthAwarePaginator
    {
        return $this->bookRepository->paginate($perPage);
    }

    public function getBookById(int $id): Book
    {
        $book = $this->bookRepository->findById($id);
        if (! $book) {
            throw new NotFoundBookException('Book not found');
        }

        return $book;
    }

    public function createBook(array $data): Book
    {
        return $this->bookRepository->create($data);
    }

    public function updateBook(Book $book, array $data): Book
    {
        return $this->bookRepository->update($book, $data);
    }

    public function deleteBook(Book $book): void
    {
        $this->bookRepository->delete($book);
    }
}
