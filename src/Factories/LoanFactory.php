<?php

namespace Factories;

use Models\Loan;

readonly class LoanFactory extends Factory
{
    public function get(?int $id = null, ?string $reference = null, ?int $memberId = null, ?int $state = null, ?int $limit = null, ?int $offset = null): array|Loan
    {
        if ($id) {
            return $this->getById(($id));
        }
        if ($reference) {
            return $this->getByReference($reference);
        }
        if ($memberId) {
            return $this->getByMemberId($memberId, $limit, $offset);
        }
        if ($state) {
            return $this->getByState($state);
        }
        return $this->getAll($limit, $offset);
    }
    public function insert(int $memberId, string $reference, int $state, string $dueDate): Loan
    {
        $id = $this->databaseService->insert("INSERT IGNORE INTO Loan (member_id, reference, state, due_date)  VALUES (?,?,?)", [$memberId, $reference,$state, $dueDate]);

        return $this->getById($id);
    }

    public function update(string $reference, ?int $state = null): Loan
    {
        if ($state) {
            return $this->updateState($state, $reference);
        }
        return $this->updateUpdatedAt($reference);
    }

    public function delete(int $id): bool
    {
        return $this->databaseService->delete("DELETE FROM Loan WHERE ISBN = ?", [$id]);
    }

    private function getById(int $id): Loan
    {
        $result = $this->databaseService->get("SELECT * FROM Loan WHERE id = ?", [$id])[0];
        $loan = new Loan((int) $result['id'], $result['member_id'], $result['reference'], $result['state'], $result['due_date'], $result['created_at'], $result['updated_at']);
        return $loan;
    }

    private function getByReference(string $reference): Loan
    {
        $result = $this->databaseService->get('SELECT * FROM Loan WHERE reference = ?', [$reference]);
        $loan = new Loan((int) $result['id'], $result['member_id'], $result['reference'], $result['state'], $result['due_date'], $result['created_at'], $result['updated_at']);
        return $loan;
    }

    private function getByMemberId(int $memberId, int $limit, int $offset): array
    {
        $results = $this->databaseService->get("SELECT * FROM Loan WHERE memberId = ? LIMIT ? OFFSET ?", [$memberId, $limit, $offset]);
        $loans = array_map(callback: fn($result): Loan => new Loan((int) $result['id'], $result['member_id'], $result['reference'], $result['state'], $result['due_date'], $result['created_at'], $result['updated_at']), array: $results);
        return $loans;
    }

    private function getAll(int $limit, int $offset): array
    {
        $results = $this->databaseService->get("SELECT * FROM Loan LIMIT ? OFFSET ?", [$limit, $offset]);
        $loans = array_map(callback: fn($result): Loan => new Loan((int) $result['id'], $result['member_id'], $result['reference'], $result['state'], $result['due_date'], $result['created_at'], $result['updated_at']), array: $results);
        return $loans;
    }

    private function getByState(string $state): array
    {
        $results = $this->databaseService->get("SELECT * FROM Loan WHERE state = ?", [$state]);
        $loans = array_map(callback: fn($result): Loan => new Loan((int) $result['id'], $result['member_id'], $result['reference'], $result['state'], $result['due_date'], $result['created_at'], $result['updated_at']), array: $results);
        return $loans;
    }


    private function updateUpdatedAt(string $reference): Loan | null
    {
        $modifiedRows = $this->databaseService->update("UPDATE Loan SET updated_at = current_timestamp() WHERE ISBN = ? LIMIT ? OFFSET ?", [$reference]);
        if ($modifiedRows  == 0) {
            return null;
        }
        return $this->getByReference($reference);
    }
    private function updateState(string $state, string $reference): Loan | null
    {
        $modifiedRows = $this->databaseService->update("UPDATE Loan SET state = ? WHERE reference = ?", [$state, $reference]);
        if ($modifiedRows == 0) {
            return null;
        }
        return $this->getByReference($reference);
    }
}
