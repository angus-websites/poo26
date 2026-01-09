<?php

uses()->group('screenshot');

it('ensures ui for all routes is unchanged (Desktop)', function (string $route) {
    $page = visit($route);
    $page->assertScreenshotMatches();
})->with('publicRoutes');

it('ensures ui for all routes is unchanged (Mobile)', function (string $route) {
    $page = visit($route)->on()->mobile();
    $page->assertScreenshotMatches();
})->with('publicRoutes');

it('ensures ui for all routes is unchanged (Desktop, Dark)', function (string $route) {
    $page = visit($route)->on()->inDarkMode();
    $page->assertScreenshotMatches();
})->with('publicRoutes');

it('ensures ui for all routes is unchanged (Mobile, Dark)', function (string $route) {
    $page = visit($route)->on()->mobile()->inDarkMode();
    $page->assertScreenshotMatches();
})->with('publicRoutes');
