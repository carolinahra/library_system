<?php

namespace Requests\MemberRequests;

use InvalidArgumentException;
use Requests\Request;



final class GetMemberRequestDTO extends Request
{
    public function __construct(public ?int $id = null, public ?string $name = null, public ?string $email = null, public ?int $state = null, public ?int $limit = null, public ?int $offset = null) {}

    private function validate(?int $id = null, ?string $name = null, ?string $email = null, ?int $state = null, ?int $limit = null, ?int $offset = null): void
    {
        if ($id && !$this->$this->isValidNumber($id)) {
            throw new InvalidArgumentException("");
        }
        if ($name && !$this->isValidString($name)) {
            throw new InvalidArgumentException("");
        }
        if ($email && !$this->isValidEmail($email)) {
            throw new InvalidArgumentException("");
        }
        if ($state && !$this->isValidState($state)) {
            throw new InvalidArgumentException("");
        }
        if ($limit && !$this->isValidNumber($limit)) {
            throw new InvalidArgumentException("");
        }
        if ($offset && !$this->isValidNumber($offset)) {
            throw new InvalidArgumentException("");
        }
    }

    public static function fromRequest(
        ?int $id = null,
        ?string $name = null,
        ?string $email = null,
        ?int $state = null,
        ?int $limit = null,
        ?int $offset = null
    ): GetMemberRequestDTO {
        $self = new self();
        $self->validate($id, $name, $email, $state, $limit, $offset);
        $DTO = new self($id, $name, $email, $state, $limit, $offset);
        return $DTO;
    }
}
