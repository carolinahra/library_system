<?php
namespace Models;
readonly class Loan {
    public function __construct(
        public int $id,
        public int $memberId,
        public string $reference,
        public int $state,
        public string $dueDate,
        public string $createdAt,
        public string $updatedAt
        ){}
}