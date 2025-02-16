<?php

declare(strict_types=1);

namespace App\Helpers;

class CnpjHelper
{
    public static function isValid(string $cnpj): bool
    {
        $cnpj = self::sanitize($cnpj);

        if (strlen($cnpj) !== 14) {
            return false;
        }

        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        $sum = 0;
        $multipliers = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        for ($i = 0; $i < 12; $i++) {
            $sum += $cnpj[$i] * $multipliers[$i];
        }
        $remainder = $sum % 11;
        $firstCheckDigit = $remainder < 2 ? 0 : 11 - $remainder;

        if ((int)$cnpj[12] !== $firstCheckDigit) {
            return false;
        }

        $sum = 0;
        $multipliers = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        for ($i = 0; $i < 13; $i++) {
            $sum += $cnpj[$i] * $multipliers[$i];
        }
        $remainder = $sum % 11;
        $secondCheckDigit = $remainder < 2 ? 0 : 11 - $remainder;

        return (int)$cnpj[13] === $secondCheckDigit;
    }

    public static function sanitize(string $cnpj): string
    {
        return preg_replace('/\D/', '', $cnpj);
    }

    public static function mask(string $cnpj): string
    {
        $cnpj = self::sanitize($cnpj);
        return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $cnpj);
    }

    public static function hide(string $cnpj): string
    {
        $cnpj = self::sanitize($cnpj);
        return substr($cnpj, 0, 2) . '.***.***/' . substr($cnpj, 8, 4) . '-' . substr($cnpj, -2);
    }
}