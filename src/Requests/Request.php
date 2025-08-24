<?php

namespace Requests;

class Request
{
    public function __construct() {}



    protected static function isValidString(string $string): bool
    {
        $regex = '/^[A-Za-zÁÉÍÓÚáéíóúÑñ]+(?: [A-Za-zÁÉÍÓÚáéíóúÑñ]+)*$/u';
        return (bool) preg_match($regex, $string);
    }

    protected static function isValidEmail(string $email): bool
    {
        $regex = '/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/';
        return (bool) preg_match($regex, $email);
    }

    protected static function isValidState(int $state): bool
    {
        return $state == 0 || $state == 1;
    }

    protected static function isValidNumber(int $number): bool
    {
        return is_int($number);
    }
}
