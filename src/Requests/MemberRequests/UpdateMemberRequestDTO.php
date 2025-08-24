<?php

namespace Requests\MemberRequests;


use InvalidArgumentException;
use Requests\Request;

class UpdateMemberRequestDTO extends Request
{
    public function __construct(public string $email, public ?string $name = null, public ?int $state = null) {}


    private static function validate(string $email, ?string $name = null, ?int $state = null): void
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
        string $email,
        ?string $name = null,
        ?int $state = null,

    ): UpdateMemberRequestDTO {
        self::validate($email, $name, $state);
        $DTO = new self($email, $name, $state);
        return $DTO;
    }
}
