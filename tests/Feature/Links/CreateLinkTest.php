<?php


it('may sign in the user', function () {
    Event::fake();

    User::factory()->create([ // assumes RefreshDatabase trait is used on Pest.php...
        'email' => 'nuno@laravel.com',
        'password' => 'password',
    ]);

    $page = visit('/')->on()->mobile()->firefox();

    $page->click('Sign In')
        ->assertUrlIs('/login')
        ->assertSee('Sign In to Your Account')
        ->fill('email', 'nuno@laravel.com')
        ->fill('password', 'password')
        ->click('Submit')
        ->assertSee('Dashboard');

    $this->assertAuthenticated();

    Event::assertDispatched(UserLoggedIn::class);
});
