<?php

namespace Requests\MemberRequests;

class DeleteMemberRequestDTO
{
    public function __construct(public string $email) {}
}
