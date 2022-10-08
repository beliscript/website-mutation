<?php

namespace App\Validation;

class UserValidation
{
    // public function custom_rule(): bool
    // {
    //     return true;
    // }

    public function validateUsername(string $str, string $fields, array $data): bool
    {
        return true;
    }

    public function validatePassword(string $str, string $fields, array $data): bool
    {
        return true;
    }

    public function validateEmail(string $str, string $fields, array $data): bool
    {
        return true;
    }

    public function validatePhone(string $str, string $fields, array $data): bool
    {
        return true;
    }

    public function validateAddress(string $str, string $fields, array $data): bool
    {
        return true;
    }
    
}
