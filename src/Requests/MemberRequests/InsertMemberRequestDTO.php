<?php

namespace Requests\MemberRequests;

use InvalidArgumentException;
use Requests\Request;


class InsertMemberRequestDTO extends Request
{
    public function __construct(public string $name, public string $email, public int $state) {}
    private static function validate(string $name, string $email, int $state): void
    {
        if ($name && !parent::isValidString($name)) {
            throw new InvalidArgumentException("");
        }
        if ($email && !parent::isValidEmail($email)) {
            throw new InvalidArgumentException("");
        }
        if ($state && !parent::isValidState($state)) {
            throw new InvalidArgumentException("");
        }
    }

    public static function fromRequest(

        string $name,
        string $email,
        int $state


    ): InsertMemberRequestDTO {
        
        InsertMemberRequestDTO::validate($name, $email, $state);
        $DTO = new self( $name, $email, $state);
        return $DTO;
    }
}
