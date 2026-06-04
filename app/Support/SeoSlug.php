<?php

namespace App\Support;

use Illuminate\Support\Str;

/**
 * Builds URL-safe SEO slugs from Arabic (or mixed) titles using Laravel's transliteration.
 */
class SeoSlug
{
    public const MAX_LENGTH = 191;

    public static function fromTitle(string $title, string $asciiFallback): string
    {
        $normalized = trim(preg_replace('/\s+/u', ' ', $title));
        $base = Str::slug($normalized);

        if ($base === '') {
            $base = Str::slug($asciiFallback);
        }

        if ($base === '') {
            $base = $asciiFallback;
        }

        return Str::substr($base, 0, self::MAX_LENGTH);
    }

    /**
     * @param  callable(string): bool  $isTaken
     */
    public static function unique(string $base, callable $isTaken): string
    {
        $base = Str::substr($base, 0, self::MAX_LENGTH);
        $candidate = $base;
        $n = 2;

        while ($isTaken($candidate)) {
            $suffix = '-'.$n;
            $maxBaseLen = max(1, self::MAX_LENGTH - strlen($suffix));
            $candidate = Str::substr($base, 0, $maxBaseLen).$suffix;
            $n++;
        }

        return $candidate;
    }
}
