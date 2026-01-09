<?php

it('no smoke for public pages', function (string $route) {
    $page = visit($route);
    $page->assertNoSmoke()
        ->assertNoAccessibilityIssues(0);
})->with('publicRoutes');

