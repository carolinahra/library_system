<?php

namespace Container;

use Factories\MemberFactory;
use Controllers\MemberController;
use Services\DatabaseService;
use Services\MemberService;

class Container
{
    public function __construct(
        private array $databaseConfig,
        private ?DatabaseService $databaseService = null,
        private ?MemberFactory $memberFactory = null,
        private ?MemberService $memberService = null,
        private ?MemberController $memberController = null
    ) {}

    public function getDatabaseService(): DatabaseService
    {
        if ($this->databaseService) {
            return $this->databaseService;
        }
        $this->databaseService = new DatabaseService($this->databaseConfig);
        return $this->databaseService;
    }

    public function getMemberFactory(): MemberFactory
    {
        if ($this->memberFactory) {
            return $this->memberFactory;
        }
        $this->memberFactory = new MemberFactory($this->getDatabaseService());
        return $this->memberFactory;
    }

    public function getMemberService(): MemberService
    {
        if ($this->memberService) {
            return $this->memberService;
        }
        $this->memberService = new MemberService($this->getMemberFactory());
        return $this->memberService;
    }
       public function getMemberController(): MemberController
    {
        if ($this->memberController) {
            return $this->memberController;
        }
        $this->memberController = new MemberController($this->getMemberService());
        return $this->memberController;
    }
}
