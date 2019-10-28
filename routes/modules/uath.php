<?php


Route::group(['middleware' => ['auth'],'middleware' => ['role:administrator'], 'prefix' => 'uath', 'as' => 'uath.'], function () {
    //-----------Directorio-------------------------------------------------------------------------------------------------------------------
    Route::get('DirectorioIndex', 'Report\UathController@DirectorioIndex');
    Route::post('DirectorioEliminar', 'Report\UathController@DirectorioEliminar');
    Route::get('datatableDirectorio/', 'Report\UathController@getDatatable');
    Route::get('EditarPerfil', 'Report\UathController@EditarPerfil')->name('editarPerfil');
    Route::post('SaveDirectorio', 'Report\UathController@SaveDirectorio');
    Route::post('DirectorioBandejasUser', 'Report\UathController@DirectorioBandejasUser');

    
});