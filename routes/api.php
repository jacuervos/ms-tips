<?php

use App\Models\Rol;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth.jwt', 'role:'.Rol::ADMIN])->group(function () {
    Route::get('tips_web', '\App\Http\Controllers\TipIndexController@index')->name('tip.index'); //Mostrar tips
    Route::post('tips_web', '\App\Http\Controllers\TipStoreController@store')->name('tip.store'); //Crear tips
});


