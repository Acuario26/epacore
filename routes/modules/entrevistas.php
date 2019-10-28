<?php


Route::group(['middleware' => ['auth'],'middleware' => ['role:Entrevistador'], 'prefix' => 'encuestador', 'as' => 'encuestador.'], function () {
    //-----------Directorio-------------------------------------------------------------------------------------------------------------------
    Route::get('SeguimientoPostulante', 'Entrevistas\EntrevistadorController@DirectorioIndex');
    Route::post('Descartar', 'Entrevistas\EntrevistadorController@Descartar');
    Route::get('datatablePostulante/{dato}', 'Entrevistas\EntrevistadorController@getDatatable');
    Route::post('Save', 'Entrevistas\EntrevistadorController@Save');

});