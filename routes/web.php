<?php

use App\Http\Controllers\LinkResolverController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SnippetController;
use App\Http\Controllers\SystemController;
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

// Show Snippets
Route::get('/snippets/{snippet}', [SnippetController::class, 'show'])
    ->name('messages.show');


// System information
Route::get('/version', [SystemController::class, 'version']);
Route::get('/info', [SystemController::class, 'info']);

// Link Resolver
Route::get('{link:slug}', [LinkResolverController::class, 'resolve'])
    ->name('links.resolve');
