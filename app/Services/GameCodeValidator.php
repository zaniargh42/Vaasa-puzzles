<?php

namespace App\Services;

class GameCodeValidator
{
    public function normalize(string $code): string
    {
        $code = mb_strtoupper(trim($code));

        $replacements = [
            'Å' => 'A',
            'Ä' => 'A',
            'Ö' => 'O',
            'É' => 'E',
            'Ü' => 'U',
        ];

        $code = strtr($code, $replacements);
        $code = preg_replace('/[\s.]+/u', '', $code) ?? $code;

        return $code;
    }

    public function matches(string $input, string $expected, ?array $alternatives = null): bool
    {
        $normalizedInput = $this->normalize($input);
        $candidates = array_merge([$expected], $alternatives ?? []);

        foreach ($candidates as $candidate) {
            if ($normalizedInput === $this->normalize($candidate)) {
                return true;
            }
        }

        return false;
    }
}
