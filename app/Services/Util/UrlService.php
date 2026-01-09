<?php

namespace App\Services\Util;

/**
 * Service to normalize URLs by ensuring they have a proper scheme.
 */
class UrlService
{
    public static function normalize($url): string
    {
        $url = trim($url);

        if (! preg_match('#^https?://#i', $url)) {
            $url = 'https://'.$url;
        }

        return $url;
    }

    public static function validate(string $url): bool
    {
        // Step 1: Basic URL syntax check
        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }

        // Step 2: Check host contains at least one dot
        $host = parse_url($url, PHP_URL_HOST);

        if (! $host || ! str_contains($host, '.')) {
            return false;
        }

        return true;
    }
}
