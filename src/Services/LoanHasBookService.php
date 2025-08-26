<?php

namespace Services;

use Factories\LoanHasBookFactory;
use Models\LoanHasBook;

readonly class LoanHasBookService {
    public function __construct(private LoanHasBookFactory $loanHasBookFactory) {}

    public function get(?int $id = null, ?int $loanId = null, ?int $bookId = null, ?int $limit = null, ?int $offset = null): LoanHasBook|array{
        return $this->loanHasBookFactory->get($id, $loanId, $bookId, $limit, $offset);
    }

    public function insert(int $bookId, int $loanId): LoanHasBook {
        return $this->loanHasBookFactory->insert($bookId, $loanId);
    }

    public function update(int $loanId, int $bookId,?int $newLoanId = null, ?int $newBookId = null): LoanHasBook {
        return $this->loanHasBookFactory->update($bookId, $loanId, $newLoanId, $newBookId);
    }

    public function delete(int $loanId, int $bookId): bool {
        return $this->loanHasBookFactory->delete($loanId, $bookId);
    }
}