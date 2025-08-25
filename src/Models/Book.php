<?php
namespace Models;
class Book {
    public function __construct(
        public int $id, 
        public string $ISBN,
        public string $name,
        public int $stock,
        public int $state,
        public string $createdAt,
        public string $updatedAt,
        ) {}
}