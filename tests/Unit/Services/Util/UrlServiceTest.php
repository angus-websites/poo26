<?php

use App\Services\Util\UrlService;

describe('UrlService::normalize', function () {

    it('adds https scheme when missing', function () {
        $url = 'google.com';

        $normalized = UrlService::normalize($url);

        expect($normalized)->toBe('https://google.com');
    });

    it('does not modify https urls', function () {
        $url = 'https://example.com';

        $normalized = UrlService::normalize($url);

        expect($normalized)->toBe('https://example.com');
    });

    it('does not modify http urls', function () {
        $url = 'http://example.com';

        $normalized = UrlService::normalize($url);

        expect($normalized)->toBe('http://example.com');
    });

    it('trims surrounding whitespace', function () {
        $url = '   google.com   ';

        $normalized = UrlService::normalize($url);

        expect($normalized)->toBe('https://google.com');
    });

    it('preserves paths and query strings', function () {
        $url = 'example.com/foo/bar?x=1&y=2';

        $normalized = UrlService::normalize($url);

        expect($normalized)->toBe('https://example.com/foo/bar?x=1&y=2');
    });

    it('preserves fragments', function () {
        $url = 'example.com/page#section';

        $normalized = UrlService::normalize($url);

        expect($normalized)->toBe('https://example.com/page#section');
    });

});

describe('UrlService::validate', function () {

    it('validates a proper https url', function () {
        $url = 'https://example.com';

        $isValid = UrlService::validate($url);

        expect($isValid)->toBeTrue();
    });

    it('validates a proper http url', function () {
        $url = 'http://example.com';

        $isValid = UrlService::validate($url);

        expect($isValid)->toBeTrue();
    });

    it('invalidates a url without scheme', function () {
        $url = 'example.com';

        $isValid = UrlService::validate($url);

        expect($isValid)->toBeFalse();
    });

    it('invalidates a malformed url', function () {
        $url = 'htp:/example..com';

        $isValid = UrlService::validate($url);

        expect($isValid)->toBeFalse();
    });

    it('invalidates an empty string', function () {
        $url = '';

        $isValid = UrlService::validate($url);

        expect($isValid)->toBeFalse();
    });

    it('invalidates a url without dot in name', function () {
        $url = 'https://google';

        $isValid = UrlService::validate($url);

        expect($isValid)->toBeFalse();
    });


});
