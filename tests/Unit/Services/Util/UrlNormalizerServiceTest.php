<?php

use App\Services\Util\UrlNormalizerService;

describe('UrlNormalizerService::normalize', function () {

    it('adds https scheme when missing', function () {
        $url = 'google.com';

        $normalized = UrlNormalizerService::normalize($url);

        expect($normalized)->toBe('https://google.com');
    });

    it('does not modify https urls', function () {
        $url = 'https://example.com';

        $normalized = UrlNormalizerService::normalize($url);

        expect($normalized)->toBe('https://example.com');
    });

    it('does not modify http urls', function () {
        $url = 'http://example.com';

        $normalized = UrlNormalizerService::normalize($url);

        expect($normalized)->toBe('http://example.com');
    });

    it('trims surrounding whitespace', function () {
        $url = '   google.com   ';

        $normalized = UrlNormalizerService::normalize($url);

        expect($normalized)->toBe('https://google.com');
    });

    it('preserves paths and query strings', function () {
        $url = 'example.com/foo/bar?x=1&y=2';

        $normalized = UrlNormalizerService::normalize($url);

        expect($normalized)->toBe('https://example.com/foo/bar?x=1&y=2');
    });

    it('preserves fragments', function () {
        $url = 'example.com/page#section';

        $normalized = UrlNormalizerService::normalize($url);

        expect($normalized)->toBe('https://example.com/page#section');
    });

});
