<?php

namespace App\Repositories;

use App\Models\Book;
use App\Repositories\Contracts\BookRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class BookRepository implements BookRepositoryInterface
{
    public function getAll(): Collection
    {
        return Book::all();
    }

    public function paginate(int $perPage): LengthAwarePaginator
    {
        return Book::paginate($perPage);
    }

    public function findById(int $id): ?Book
    {
        return Book::find($id);
    }

    public function create(array $data): Book
    {
        return Book::create($data);
    }

    public function update(Book $book, array $data): Book
    {
        $book->update($data);

        return $book;
    }

    public function delete(Book $book): void
    {
        $book->delete();
    }
}
