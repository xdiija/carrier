<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Closure;
use App\Helpers\CnpjHelper;

class ValidCnpj implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!CnpjHelper::isValid($value)) {
            $fail("O campo $attribute é inválido.");
        }
    }
}