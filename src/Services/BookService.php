<?php

namespace Services;

use Factories\BookFactory;
use Models\Book;

readonly class BookService
{
    public function __construct(private BookFactory $bookFactory) {}

    public function get(?int $id = null, ?string $ISBN = null, ?string $name = null, ?int $state = null, ?int $limit = null, ?int $offset = null): Book
    {
        return $this->bookFactory->get($id, $ISBN, $name, $state, $limit, $offset);
    }

    public function insert(string $ISBN, string $name, int $stock, int $state)
    {
        return $this->bookFactory->insert($ISBN, $name, $stock, $state);
    }

    public function update(string $ISBN, ?string $name = null, ?int $state = null)
    {
        return $this->bookFactory->update($ISBN, $name, $state);
    }

    public function delete(string $ISBN) {
        return $this->bookFactory->delete($ISBN);
    }
}
