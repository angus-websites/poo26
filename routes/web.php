<?php

use App\Http\Controllers\LinkResolverController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('public.links.create');
})->name('home');

Route::get('/messages/create', function () {
    return view('public.messages.create');
})->name('messages.create');

// Show Messages
Route::get('/messages/{message}', [MessageController::class, 'show'])
    ->name('messages.show');


Route::get('/snippets/create', function () {
    return view('public.snippets.create');
})->name('snippets.create');


// Link Resolver
Route::get('{link:slug}', [LinkResolverController::class, 'resolve'])
    ->name('links.resolve');

