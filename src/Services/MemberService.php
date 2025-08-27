<?php

namespace Services;

use Factories\MemberFactory;
use Models\Member;

class MemberService
{
    public function __construct(private readonly MemberFactory $memberFactory) {}



    public function getMany(?string $name = null, ?int $state = null, ?int $limit = null, ?int $offset = null): array
    {
        return $this->memberFactory->get($name, $state, $limit, $offset);
    }
    public function getOne(?int $id = null, ?string $email = null): Member
    {
        return $this->memberFactory->get($id, $email);
    }

    public function insert(string $name, string $email, int $state): Member
    {
        return $this->memberFactory->insert($name, $email, $state);
    }

    public function update(?string $name = null, string $email, ?int $state = null): Member
    {
        return $this->memberFactory->update($email, $name, $state);
    }

    public function delete(string $email): bool
    {
        return $this->memberFactory->delete($email);
    }
}
