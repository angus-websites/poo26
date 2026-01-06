<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('public.links.create');
})->name('home');

Route::get('/messages/create', function () {
    return view('public.messages.create');
})->name('messages.create');

Route::get('/snippets/create', function () {
    return view('public.snippets.create');
})->name('snippets.create');
