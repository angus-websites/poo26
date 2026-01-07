<?php


$publicRoutes = [
    "/" => "Home Page",
    "/messages/create" => "New Message Page",
    "/snippets/create" => "New Snippet Page",
];

it('no smoke for public pages', function () use ($publicRoutes) {
    $pages = visit(array_keys($publicRoutes));
    $pages->assertNoSmoke()
        ->assertNoAccessibilityIssues(0);
});

it('ensures ui for all routes is unchanged (Desktop)', function () use ($publicRoutes) {
    $pages = visit(array_keys($publicRoutes));
    $pages->assertScreenshotMatches();
});

it('ensures ui for all routes is unchanged (Mobile)', function () use ($publicRoutes) {
    $pages = visit(array_keys($publicRoutes))->on()->mobile();
    $pages->assertScreenshotMatches();
});

it('ensures ui for all routes is unchanged (Desktop, Dark)', function () use ($publicRoutes) {
    $pages = visit(array_keys($publicRoutes))->on()->inDarkMode();
    $pages->assertScreenshotMatches();
});

it('ensures ui for all routes is unchanged (Mobile, Dark)', function () use ($publicRoutes) {
    $pages = visit(array_keys($publicRoutes))->on()->mobile()->inDarkMode();
    $pages->assertScreenshotMatches();
});
