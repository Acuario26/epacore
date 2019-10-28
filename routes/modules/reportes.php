<?php


Route::group(['middleware' => ['auth'], 'prefix' => 'reporte', 'as' => 'reporte.'], function () {

    //-----------Reportes-------------------------------------------------------------------------------------------------------------------

    Route::get('ReporteIndex', 'Report\UathController@index');
    Route::post('prueba', 'Report\UathController@prueba');
    Route::post('prueba2', 'Report\UathController@prueba2');

    //-----------Nuevo Reporte
    Route::get('ReporteGeneralIndex', 'Report\ReportController@index');
    Route::get('ReporteGeneralIndexRecaudacion', 'Report\ReportController@indexRecaudacion');
    Route::post('reporteGeneralDatos', 'Report\ReportController@reporteGeneralDatos');
});

