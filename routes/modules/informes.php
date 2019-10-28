<?php
Route::post('dropzone', 'Informes\InformeTicController@uploadFiles');

Route::post('/images-save', 'UploadImagesController@store');
Route::post('/images-delete', 'UploadImagesController@destroy');


Route::group(['prefix' => 'informe', 'as' => 'informe.'], function () {
    //-----------Directorio-------------------------------------------------------------------------------------------------------------------
    Route::get('informetecnicotics', 'Informes\InformeTicController@InformeTICS')->name('informesLink');
    Route::get('informespendientesR', 'Informes\InformeTicController@informespendientesR');
    Route::get('informespendientesA', 'Informes\InformeTicController@informespendientesA');

    Route::post('saveInforme', 'Informes\InformeTicController@saveInforme');
    Route::post('getDatatableFecha', 'Informes\InformeTicController@getDatatableFecha');
    Route::post('getInformes', 'Informes\InformeTicController@getInformes');
    Route::post('getInventario', 'Informes\InformeTicController@getInventario');
    Route::post('getUserGlpi', 'Informes\InformeTicController@getUserGlpi');
    Route::post('getCargarProblemasEquipos', 'Informes\InformeTicController@getCargarProblemasEquipos');
    Route::post('agregaProblemas', 'Informes\InformeTicController@agregaProblemas');
    Route::post('borrarProblemas', 'Informes\InformeTicController@borrarProblemas');
    Route::post('eliminardata', 'Informes\InformeTicController@eliminardata');
    Route::post('aprobarInforme', 'Informes\InformeTicController@aprobarInforme');
    
    Route::get('informetecnicoticsFRAME', 'Informes\InformeTicController@InformeTICSFRAME');
    
});


