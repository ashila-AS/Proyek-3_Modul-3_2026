<?php

use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/activities');
});

Route::resource('activities', ActivityController::class);
