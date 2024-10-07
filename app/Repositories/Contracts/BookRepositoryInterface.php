<?php

namespace App\Repositories\Contracts;

use App\Models\Book;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface BookRepositoryInterface
{
    public function getAll(): Collection;

    public function paginate(int $perPage): LengthAwarePaginator;

    public function findById(int $id): ?Book;

    public function create(array $data): Book;

    public function update(Book $book, array $data): Book;

    public function delete(Book $book): void;
}
