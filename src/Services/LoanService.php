<?php
namespace Services;
use Factories\LoanFactory;
use Models\Loan;

readonly class LoanService {
    public function __construct(private LoanFactory $loanFactory) {}

    public function get(?int $id = null, ?string $reference = null, ?int $memberId = null, ?int $state = null, ?int $limit = null, ?int $offset = null): Loan|array {
        return $this->loanFactory->get($id, $reference, $memberId, $state, $limit, $offset);
    }

    public function insert(int $memberId, string $reference, int $state, string $dueDate): Loan {
        return $this->loanFactory->insert($memberId, $reference, $state, $dueDate);
    }

    public function update(string $reference, ?int $state = null) {
        return $this->loanFactory->update($reference, $state);  
    }

    public function delete(string $reference): bool {
        return $this->loanFactory->delete($reference);
    }
}