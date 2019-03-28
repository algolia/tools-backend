<?php

Route::middleware(['auth'])->group(function () {
    Route::get('/login/current_user', 'AuthController@currentUser');

    Route::get('/apps', function (\Illuminate\Http\Request $request) {
        return ['ok', 'truc', 'lolilol'];
    });
});

Route::get('/login/callback', 'AuthController@algoliaLoginCallback');

Route::get('/clear', function (\Illuminate\Http\Request $request) {
    $request->session()->flush();
});

Route::get('/', function (\Illuminate\Http\Request $request) {
    dd($request->session()->get('accessToken'));
});