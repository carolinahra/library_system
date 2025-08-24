<?php

namespace Services;

use Factories\MemberFactory;
use Models\Member;

class MemberService
{
    public function __construct(private readonly MemberFactory $memberFactory) {}

    public function get(?int $id = null, ?string $name = null, ?string $email = null, ?int $state = null, ?int $limit = null, ?int $offset = null): array|Member
    {
        return $this->memberFactory->get($id, $name, $email, $state, $limit, $offset);
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
