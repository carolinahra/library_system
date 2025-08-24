<?php

namespace Models;

readonly class Member
{
    public function __construct(public ?int $id = null, public string $name, public string $email, public int $state, public ?string $createdAt = null, public ?string $updatedAt = null) {}
}
