<?php

namespace App\Support;

class Translations
{
    public static function flatten(array $translations, string $prefix = ''): array
    {
        $result = [];

        foreach ($translations as $key => $value) {
            $fullKey = $prefix === '' ? $key : "{$prefix}.{$key}";

            if (is_array($value)) {
                $result += self::flatten($value, $fullKey);
            } else {
                $result[$fullKey] = $value;
            }
        }

        return $result;
    }
}
