<?php

namespace Services;

use Models\Loan;
use Exception;
use Services\DatabaseService;
use Services\LoanHasBookService;
use Services\LoanService;
use Services\BookService;
use Services\MemberService;

readonly class LendingService
{
    public function __construct(
        private MemberService $memberService,
        private BookService $bookService,
        private LoanService $loanService,
        private LoanHasBookService $loanHasBookService,
        private DatabaseService $dataBaseService
    ) {}

    public function lend(string $memberEmail, array $bookISBNs): Loan
    {
        $member = $this->memberService->getOne(email: $memberEmail);
        $books = $this->bookService->getMany(ISBNs: $bookISBNs);
        foreach ($books as $book) {
            if (!$book->isBookAvailable()) {
                throw new Exception('');
            }
        }
        $reference = $this->generateNonExistingReference();
        $dueDate = $this->generateDueDate();
        $this->dataBaseService->startTransaction();
        try {
            $loan = $this->loanService->insert($member->id, $reference, 1, $dueDate);
            foreach ($books as $book) {
                $this->loanHasBookService->insert($book->id, $loan->id);
            }
            $this->dataBaseService->commit();
            return $loan;
        } catch (Exception $e) {
            $this->dataBaseService->rollback();
            throw $e;
        }
    }



    private function generateNonExistingReference(): string
    {
        $reference = $this->generateReference();
        while ($this->isExistingReference($reference)) {
            $reference = $this->generateReference();
        }
        return $reference;
    }
    private function generateReference(): string
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzACBDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $reference = '';
        for ($i = 0; $i < 10; $i++) {
            $reference .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $reference;
    }
    private function isExistingReference(string $reference): bool
    {
        return $this->loanService->isExistingReference($reference);
    }

    private function generateDueDate(): string
    {
        $dueDate = strtotime(datetime: '+2 months');
        $formatDueDate = date('Y-m-d', $dueDate);
        return $formatDueDate;
    }
}
