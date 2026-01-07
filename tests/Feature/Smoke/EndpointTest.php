<?php


it('all public GET routes respond with 200', function () {

    $routes = [
        "/" => "Home Page",
        "/messages/create" => "New Message Page",
        "/snippets/create" => "New Snippet Page",
    ];

    foreach ($routes as $uri => $name) {
        $response = $this->get($uri);

        if ($response->status() !== 200) {
            throw new Exception("The route '{$uri}' ({$name}) did not respond with 200 OK");
        }

        // Assert OK
        $response->assertOk();
    }
});

it('ensures ui for all routes is unchanged', function () {

    $routes = [
        "/" => "Home Page",
        "/messages/create" => "New Message Page",
        "/snippets/create" => "New Snippet Page",
    ];

    $pages = visit(
        array_keys($routes)
    );

    $pages->assertScreenshotMatches();
});

