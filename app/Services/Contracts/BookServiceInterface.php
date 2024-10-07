<?php

namespace App\Services\Contracts;

use App\Models\Book;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface BookServiceInterface
{
    public function getAllBooks(): Collection;

    public function getPaginatedBooks(int $perPage): LengthAwarePaginator;

    public function getBookById(int $id): Book;

    public function createBook(array $data): Book;

    public function updateBook(Book $book, array $data): Book;

    public function deleteBook(Book $book): void;
}
