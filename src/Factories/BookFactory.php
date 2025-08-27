<?php

namespace Factories;

use Factories\Factory;
use Models\Book;

readonly final class BookFactory extends Factory
{
    public function get(?int $id = null, ?string $ISBN = null, ?string $name = null, ?int $state = null, ?int $limit = null, ?int $offset = null, ?array $ISBNs = null): array|Book
    {
        if ($id) {
            return $this->getById(($id));
        }
        if ($name) {
            return $this->getByName($name, $limit, $offset);
        }
        if ($ISBN) {
            return $this->getByISBN($ISBN);
        }
        if ($state) {
            return $this->getByState($state);
        }
        if ($ISBNs) {
            return $this->getManyByISBNs($ISBNs);
        }
        return $this->getAll($limit, $offset);
    }
    public function insert(string $ISBN, string $name, int $stock, int $state): Book
    {
        $id = $this->databaseService->insert("INSERT IGNORE INTO Book (ISBN, name, stock, state)  VALUES (?,?,?)", [$ISBN, $name, $stock, $state]);

        return $this->getById($id);
    }

    public function update(string $ISBN, ?string $name = null, ?int $state = null): Book
    {
        if ($name) {
            return $this->updateName($name, $ISBN);
        }
        return $this->updateState($state, $ISBN);
    }

    public function delete(string $ISBN): bool
    {
        return $this->databaseService->delete("DELETE FROM Book WHERE ISBN = ?", [$ISBN]);
    }

    private function getById(int $id): Book
    {
        $result = $this->databaseService->get("SELECT * FROM Book WHERE id = ?", [$id])[0];
        $book = new Book((int) $result['id'], $result['ISBN'], $result['name'], $result['stock'], $result['state'], $result['created_at'], $result['updated_at']);
        return $book;
    }

    private function getByName(string $name, int $limit, int $offset): array
    {
        $results = $this->databaseService->get("SELECT * FROM Book WHERE name = ? LIMIT ? OFFSET ?", [$name, $limit, $offset]);
        $books = array_map(callback: fn($result): Book => new Book((int) $result['id'], $result['ISBN'], $result['name'], $result['stock'], $result['state'], $result['created_at'], $result['updated_at']), array: $results);
        return $books;
    }

    private function getAll(int $limit, int $offset): array
    {
        $results = $this->databaseService->get("SELECT * FROM Book LIMIT ? OFFSET ?", [$limit, $offset]);
        $books = array_map(callback: fn($result): Book => new Book((int) $result['id'], $result['ISBN'], $result['name'], $result['stock'], $result['state'], $result['created_at'], $result['updated_at']), array: $results);
        return $books;
    }

    private function getManyByISBNs(array $ISBNs): array
    {
        $placeholders = array_map(fn($ISBN) => '?', $ISBNs);
        $placeholders = implode(',', $placeholders);
        $results = $this->databaseService->get("SELECT * FROM Book WHERE ISBN IN ({$placeholders})", $ISBNs);
        $books = array_map(callback: fn($result): Book => new Book((int) $result['id'], $result['ISBN'], $result['name'], $result['stock'], $result['state'], $result['created_at'], $result['updated_at']), array: $results);
        return $books;
    }

    private function getByState(string $state): array
    {
        $results = $this->databaseService->get("SELECT * FROM Book WHERE state = ?", [$state]);
        $books = array_map(callback: fn($result): Book => new Book((int) $result['id'], $result['ISBN'], $result['name'], $result['stock'], $result['state'], $result['created_at'], $result['updated_at']), array: $results);
        return $books;
    }
    private function getByISBN(string $ISBN): Book
    {
        $result = $this->databaseService->get("SELECT * FROM Book WHERE ISBN = ?", [$ISBN])[0];
        $book = new Book((int) $result["id"], $result["ISBN"], $result["name"], $result["stock"], $result["state"], $result["created_at"], $result['updated_at']);
        return $book;
    }

    private function updateName(string $name, int $ISBN): Book | null
    {
        $modifiedRows = $this->databaseService->update("UPDATE Book SET name = ? WHERE ISBN = ? LIMIT ? OFFSET ?", [$name, $ISBN]);
        if ($modifiedRows  == 0) {
            return null;
        }
        return $this->getByISBN($ISBN);
    }
    private function updateState(string $state, int $ISBN): Book | null
    {
        $modifiedRows = $this->databaseService->update("UPDATE Book SET state = ? WHERE ISBN = ?", [$state, $ISBN]);
        if ($modifiedRows == 0) {
            return null;
        }
        return $this->getByISBN($ISBN);
    }
}
