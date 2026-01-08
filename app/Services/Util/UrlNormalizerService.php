<?php

namespace App\Services\Util;

/**
 * Service to normalize URLs by ensuring they have a proper scheme.
 */
class UrlNormalizerService
{
    public static function normalize($url): string
    {
        $url = trim($url);

        if (!preg_match('#^https?://#i', $url)) {
            $url = 'https://' . $url;
        }

        return $url;
    }
}
