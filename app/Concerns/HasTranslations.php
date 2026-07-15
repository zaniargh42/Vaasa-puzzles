<?php

namespace App\Concerns;

trait HasTranslations
{
    public function translate(string $attribute, ?string $locale = null): ?string
    {
        $values = $this->getAttribute($attribute);

        if (! is_array($values)) {
            return is_string($values) ? $values : null;
        }

        $locale ??= app()->getLocale();
        $fallback = config('locales.fallback', 'en');

        return $values[$locale]
            ?? $values[$fallback]
            ?? reset($values)
            ?: null;
    }
}
