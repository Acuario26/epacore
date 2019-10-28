<?php


Route::group(['middleware' => ['auth'],'middleware' => ['role:DigitadorPagos|SupervisorPagos'],
 'prefix' => 'financiera', 'as' => 'financiera.'], function () {
    //-----------Directorio-------------------------------------------------------------------------------------------------------------------
    Route::get('pagos', 'Financieras\FinancieraControlPrevioController@Index')->name('ControlPrevioLink');
    Route::get('datatablePago', 'Financieras\FinancieraControlPrevioController@getDatatable');
    Route::post('savePago', 'Financieras\FinancieraControlPrevioController@savePago');
    Route::post('eliminaPago', 'Financieras\FinancieraControlPrevioController@eliminaPago');
    Route::post('codigosRetencion', 'Financieras\FinancieraControlPrevioController@codigosRetencion');
    Route::post('identificacionBeneficiarios', 'Financieras\FinancieraControlPrevioController@identificacionBeneficiarios');
    Route::post('tiposContratos', 'Financieras\FinancieraControlPrevioController@tiposContratos');
    Route::post('areaSolicitante', 'Financieras\FinancieraControlPrevioController@areaSolicitante');
    Route::post('getDatatableFecha', 'Financieras\FinancieraControlPrevioController@getDatatableFecha');
    Route::post('buscarcontratos', 'Financieras\FinancieraControlPrevioController@buscarcontratos');
    Route::post('agregaBeneficiarios', 'Financieras\FinancieraControlPrevioController@agregaBeneficiarios');
    Route::post('borrarBeneficiario', 'Financieras\FinancieraControlPrevioController@borrarBeneficiario');
});
Route::group(['middleware' => ['auth'],'middleware' => ['role:DigitadorViaticos'], 'prefix' => 'financiera', 'as' => 'financiera.'], function () {

});
