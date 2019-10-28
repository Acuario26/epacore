
<?php


Route::group(['prefix' => 'comercial', 'as' => 'comercial.'], function () {
    //-----------Directorio-------------------------------------------------------------------------------------------------------------------
    //FACTURACION 
    Route::post('import', 'Comercial\ComercialController@import')->name('import');
    Route::post('getLote', 'Comercial\ComercialController@getLote');
    Route::post('eliminaFile', 'Comercial\ComercialController@eliminaFile');
    //RECAUDACION 
    Route::post('importR', 'Comercial\ComercialController@importR')->name('importR');
    Route::post('getLoteR', 'Comercial\ComercialController@getLoteR');
    Route::post('eliminaFileR', 'Comercial\ComercialController@eliminaFileR');
    // FACTURACION Y RECAUDACION 
    Route::get('index', 'Comercial\ComercialController@Index');
    
});


