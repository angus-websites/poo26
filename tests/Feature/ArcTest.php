<?php

arch()
    ->expect('App\Models')
    ->toBeClasses()
    ->toExtend('Illuminate\Database\Eloquent\Model')
    ->toOnlyBeUsedIn(['App\Repositories', 'App\Contracts'])
    ->ignoring('App\Models\User');

arch()
    ->expect('App\Http')
    ->toOnlyBeUsedIn('App\Http');

arch()->preset()->php();
