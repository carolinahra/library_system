<?php

use Models\Book;
use PHPUnit\Framework\TestCase;
use Services\BookService;
use Services\LoanHasBookService;
use Services\LoanService;
use Services\MemberService;
use Factories\MemberFactory;
use Services\DatabaseService;
use Factories\BookFactory;
use Factories\LoanFactory;
use Factories\LoanHasBookFactory;
use Models\Loan;
use Models\LoanHasBook;
use Models\Member;
use Services\LendingService;
use PHPUnit\Framework\MockObject\MockObject;

class LendingServiceTest extends TestCase
{
    /** @var MemberService&MockObject */
    private MemberService $memberServiceMock;
    /** @var BookService&MockObject */
    private BookService $bookServiceMock;
    /** @var LoanService&MockObject */
    private LoanService $loanServiceMock;
    /** @var LoanHasBookService&MockObject */
    private LoanHasBookService $loanHasBookServiceMock;
    /** @var DatabaseService&MockObject */
    private DatabaseService $databaseServiceMock;



    private LendingService $lendingServiceMock;

    public function testLendingService()
    {
        $email = 'martacaballero@mail.com';
        $ISBNs = ['j482jd3','kc83218'];
        $member = new Member(1, 'Marta Caballero', 'martacaballero@mail.com', 1, '2025-04-12', '2025-04-12');
        

        $books = [
            new Book(1, 'j482jd3', 'After', 2, 1, '2025-01-01', '2025-06-14'),
            new Book(2, 'kc83218', 'Alas de fuego', 4, 1, '2025-01-01', '2025-05-23')
        ];

        $loan = new Loan(1, 1, 'fjsh3j5i4', 1, '2025-10-27', '2025-08-27', '2025-08-27');
        $loanHasBook = new LoanHasBook(1,$loan->id, $books[0]->id);
       
        $this->memberServiceMock->method('getOne')->with($email)->willReturn($member);
        $this->bookServiceMock->method('getMany')->with($ISBNs)->willReturn($books);
        $this->loanServiceMock->method('insert')->willReturn($loan);
        $this->loanHasBookServiceMock->method('insert')->willReturn($loanHasBook);

        $result = $this->lendingServiceMock->lend($email, $ISBNs);
        $this->assertEquals($loan, $result);
    }
    protected function setUp(): void
    {
        // Mocks
        $this->databaseServiceMock = new DatabaseService([]);
        $this->memberServiceMock = new MemberService($this->createMock(MemberFactory::class));
        $this->bookServiceMock =  new BookService($this->createMock(BookFactory::class));
        $this->loanServiceMock = new LoanService($this->createMock(LoanFactory::class));
        $this->loanHasBookServiceMock = new LoanHasBookService($this->createMock(LoanHasBookFactory::class));
        $this->lendingServiceMock = new LendingService($this->memberServiceMock, $this->bookServiceMock, $this->loanServiceMock, $this->loanHasBookServiceMock, $this->databaseServiceMock);
    }
}
