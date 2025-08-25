<?php

namespace Models;
class LoanHasBook
{
    public function __construct(
        public int $id,
        public int $loanId,
        public int $bookId,
    ) {}
}
