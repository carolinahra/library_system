<?php

namespace Services;

use Factories\BookFactory;
use Models\Book;


readonly class BookService
{
    public function __construct(private BookFactory $bookFactory) {}

    public function getOne(?int $id = null, ?string $ISBN = null): Book
    {
        return $this->bookFactory->get($id, $ISBN);
    }

    /**
     * 
     * @param mixed $name
     * @param mixed $state
     * @param mixed $limit
     * @param mixed $offset
     * @return Book[]
     */
    public function getMany(?string $name = null, ?int $state = null, ?int $limit = null, ?int $offset = null, ?array $ISBNs = null ): array {
        return $this->bookFactory->get($name, $state, $limit, $offset, $ISBNs);
    }

    public function insert(string $ISBN, string $name, int $stock, int $state): Book
    {
        return $this->bookFactory->insert($ISBN, $name, $stock, $state);
    }

    public function update(string $ISBN, ?string $name = null, ?int $state = null): Book
    {
        return $this->bookFactory->update($ISBN, $name, $state);
    }

    public function delete(string $ISBN): bool {
        return $this->bookFactory->delete($ISBN);
    }
}
