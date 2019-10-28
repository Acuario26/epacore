<?php


Route::group(['middleware' => ['auth'],'middleware' => ['role:administrator|Recaudador|Operador|Operador2|Supervisor'], 'prefix' => 'clientes', 'as' => 'clientes.'], function () {
    //-----------Directorio-------------------------------------------------------------------------------------------------------------------
    Route::get('gestionIndex', 'Gestion\GestionController@index')->name('gestionIndex');
    Route::post('Eliminar', 'Gestion\GestionController@delete');
    Route::get('datatable/{bandeja}', 'Gestion\GestionController@getDatatable');
    Route::get('datatablePagos/{id}', 'Gestion\GestionController@getDatatablePagos');
    Route::post('Save', 'Gestion\GestionController@save');
    Route::post('/uploadFinal', 'Gestion\GestionController@uploadFinal');
    Route::post('llamadas', 'Gestion\GestionController@savellamadas');
    Route::post('savecliente', 'Gestion\GestionController@savecliente');
    Route::post('SaveAcuerdo', 'Gestion\GestionController@SaveAcuerdo');

});
Route::get('clientes/historialCall', 'Gestion\GestionController@historialCall')
->name('historialCall');

Route::get('clientes/datatableH/{bandeja}', 'Gestion\GestionController@getDatatableH');

Route::get('asignacion/llamadas', 'Gestion\GestionController@indexGestionLLamadas');
Route::get('GestionLLamadaDatatable', 'Gestion\GestionController@GestionLLamadaDatatable');
    Route::post('asignacionCulmina', 'Gestion\GestionController@asignacionCulmina');

