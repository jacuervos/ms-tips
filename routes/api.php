<?php

use App\Models\Rol;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth.jwt', 'role:'.Rol::ADMIN])->group(function () {
    Route::get('tips_web', '\App\Http\Controllers\TipIndexController@index')->name('tip.index'); //Mostrar tips
    Route::post('tips_web', '\App\Http\Controllers\TipStoreController@store')->name('tip.store'); //Crear tips
    Route::patch('{tip}/tips_web', '\App\Http\Controllers\TipUpdateController@update')->name('tip.update'); //Actualizar tip
    Route::patch('{tip}/change_state_tips', '\App\Http\Controllers\TipChangeStateController@changeStateTip')->name('tip.changeState'); //Cambiar estado tips
});

Route::middleware(['auth.jwt', 'role:'.Rol::USER])->group(function () {
    Route::get('tips_app', '\App\Http\Controllers\TipIndexController@getActivesTips')->name('tip.active'); //Mostrar tips activos en app
});


