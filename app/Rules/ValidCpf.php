<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Closure;
use App\Helpers\CpfHelper;

class ValidCpf implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!CpfHelper::isValid($value)) {
            $fail("O campo $attribute é inválido.");
        }
    }
}