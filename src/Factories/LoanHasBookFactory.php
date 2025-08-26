<?php

namespace Factories;
use Factories\Factory;
use Models\LoanHasBook;

readonly class LoanHasBookFactory extends Factory {
     public function get(?int $id = null, ?int $loanId = null, ?int $bookId = null, ?int $limit = null, ?int $offset = null): array|LoanHasBook
    {
        if ($id) {
            return $this->getById(($id));
        }
        if ($loanId && $bookId) {
            return $this->getByLoanIdAndBookId($loanId, $bookId);
        }
        if ($loanId) {
            return $this->getByLoanId($loanId);
        }
        if ($bookId) {
            return $this->getByBookId($bookId, $limit, $offset);
        }
       
        return $this->getAll($limit, $offset);
    }
    public function insert(int $bookId, int $loanId): LoanHasBook
    {
        $id = $this->databaseService->insert("INSERT IGNORE INTO Loan_has_Book (loan_id, book_id)  VALUES (?,?,?)", [$loanId, $bookId]);

        return $this->getById($id);
    }

    public function update(int $loanId, int $bookId,?int $newLoanId = null, ?int $newBookId = null): LoanHasBook
    {
        if ($newBookId) {
            return $this->updateBookId($newBookId, $loanId, $bookId);
        }
        return $this->updateLoanId($newLoanId ,$loanId, $bookId);
    }

    public function delete(int $loanId, int $bookId): bool
    {
        return $this->databaseService->delete("DELETE FROM Loan_has_Book WHERE loan_id = ? AND book_id = ?", [$loanId, $bookId]);
    }

    private function getById(int $id): LoanHasBook
    {
        $result = $this->databaseService->get("SELECT * FROM Loan_has_Book WHERE id = ?", [$id])[0];
        $loanHasBook = new LoanHasBook((int) $result['id'], $result['loan_id'], $result['book_id']);
        return $loanHasBook;
    }

    private function getByLoanIdAndBookId(int $loanId, int $bookId): LoanHasBook
    {
        $result = $this->databaseService->get('SELECT * FROM Loan_has_Book WHERE loan_id = ? AND book_id = ?', [$loanId, $bookId]);
        $loanHasBook = new LoanHasBook((int) $result['id'], $result['loan_id'], $result['book_id']);
        return $loanHasBook;
    }

    private function getByBookId(int $bookId, int $limit, int $offset): array
    {
        $results = $this->databaseService->get("SELECT * FROM Loan_has_Book WHERE memberId = ? LIMIT ? OFFSET ?", [$bookId, $limit, $offset]);
        $loanHasBooks = array_map(callback: fn($result): LoanHasBook => new LoanHasBook((int) $result['id'], $result['loan_id'], $result['book_id']), array: $results);
        return $loanHasBooks;
    }

    private function getAll(int $limit, int $offset): array
    {
        $results = $this->databaseService->get("SELECT * FROM Loan_has_Book LIMIT ? OFFSET ?", [$limit, $offset]);
        $loanHasBooks = array_map(callback: fn($result): LoanHasBook => new LoanHasBook((int) $result['id'], $result['loan_id'], $result['book_id']), array: $results);
        return $loanHasBooks;
    }

    private function getByLoanId(int $loanId): array
    {
        $results = $this->databaseService->get("SELECT * FROM Loan_has_Book WHERE loan_id = ?", [$loanId]);
        $loanHasBooks = array_map(callback: fn($result): LoanHasBook => new LoanHasBook((int) $result['id'], $result['loan_id'], $result['book_id']), array: $results);
        return $loanHasBooks;
    }


    private function updateLoanId(int $newLoanId, int $loanId, int $bookId): LoanHasBook | null
    {
        $modifiedRows = $this->databaseService->update("UPDATE Loan_has_Book SET loan_id = ? WHERE loan_id = ? AND book_id = ", [$newLoanId, $loanId, $bookId]);
        if ($modifiedRows  == 0) {
            return null;
        }
        return $this->getByLoanIdAndBookId($loanId, $bookId);
    }
    private function updateBookId(int $newBookId, int $loanId, int $bookId): LoanHasBook | null
    {
        $modifiedRows = $this->databaseService->update("UPDATE Loan_has_Book SET book_id = ? WHERE loan_id = ? AND book_id = ", [$newBookId, $loanId, $bookId]);
        if ($modifiedRows  == 0) {
            return null;
        }
        return $this->getByLoanIdAndBookId($loanId, $bookId);
    }
}