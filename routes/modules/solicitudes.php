<?php
    Route::post('registroP', 'Solicitudescj\RegistroController@registroP')->name('registroP');
    Route::post('registroPP', 'Solicitudescj\RegistroController@registroPP')->name('registroPP');

Route::group(['prefix' => 'asesor', 'as' => 'asesor.'], function () {
    Route::post('provinciaCiudad', 'Solicitudes\SolicitudesController@provinciaCiudad');
});
Route::group(['middleware' => ['auth'],'middleware' => ['role:LiderCredito|LiderCalidad|LiderRecepcion|LiderRegularizacion|AsesorCC|AsesorCRJ|LiderCC|AsesorCredito|AsesorCalidad|AsesorRecepcion|AsesorRegularizacion'], 'prefix' => 'asesor', 'as' => 'asesor.'], function () {
    Route::get('SolicitudesIndex', 'Solicitudes\SolicitudesController@index');
    Route::get('datatableDepartamentoS/{id}', 'Solicitudes\SolicitudesController@getDatatableSeguimiento');
    Route::post('ConfiguracionBP', 'Solicitudes\SolicitudesController@ConfiguracionBP');
    Route::post('ConfiguracionPlan', 'Solicitudes\SolicitudesController@ConfiguracionPlan');
    Route::post('ConfiguracionPlan2', 'Solicitudes\SolicitudesController@ConfiguracionPlan2');
    Route::post('SaveSolicitud', 'Solicitudes\SolicitudesController@SaveSolicitud');
    Route::post('SearchCedula', 'Solicitudes\SolicitudesController@searchCedula');
    Route::post('SolicitudActiva', 'Solicitudes\SolicitudesController@SolicitudActiva');
    Route::post('SolicitudEliminada', 'Solicitudes\SolicitudesController@SolicitudEliminada');
    Route::post('NSolicitud', 'Solicitudes\SolicitudesController@NSolicitud');
    Route::post('verificaNumero', 'Solicitudes\SolicitudesController@verificaNumero');

    Route::post('concatenaObservaciones', 'Solicitudes\SolicitudesController@concatenaObservaciones');
    Route::post('CantidadObsequio', 'Solicitudes\SolicitudesController@CantidadObsequio');
    Route::post('SolicitudLiberada', 'Solicitudes\SolicitudesController@SolicitudLiberada');

    Route::get('datatableDepartamento/{dato}', 'Solicitudes\SolicitudesController@getDatatable');
    Route::post('VentaNotificada', 'Solicitudes\SolicitudesController@VentaNotificada');

});

Route::group(['middleware' => ['auth'],'middleware' => ['role:LiderCredito|LiderCalidad|LiderRecepcion|LiderRegularizacion|LiderCC|AsesorCRJ|AsesorCredito|AsesorCalidad|AsesorRecepcion|AsesorRegularizacion'], 'prefix' => 'lider', 'as' => 'lider.'], function () {
    Route::post('EstadosBandeja', 'Solicitudes\SolicitudesController@EstadosBandeja');
    Route::post('CambioEstados', 'Solicitudes\SolicitudesController@CambioEstados');
    Route::get('peticionLiberacion', 'Solicitudes\SolicitudesController@peticionLiberacionIndex');
    Route::get('datatableSolicitudInactiva/{dato}', 'Solicitudes\SolicitudesController@datatableSolicitudInactiva');
    Route::post('SolicitudInactiva', 'Solicitudes\SolicitudesController@SolicitudInactiva');
});
Route::group(['middleware' => ['auth'],'middleware' => ['role:LiderCredito|LiderCalidad|LiderRecepcion|LiderRegularizacion|AsesorCredito|AsesorCRJ|AsesorCalidad|AsesorRecepcion|AsesorRegularizacion'], 'prefix' => 'asesordepartamental', 'as' => 'asesordepartamental.'], function () {
    Route::get('SeguimientoIndex', 'Solicitudes\SeguimientoController@SeguimientoIndex');
    Route::get('datatableDepartamentoS/{dato}', 'Solicitudes\SeguimientoController@getDatatableSeguimiento');
    Route::get('datatableDepartamentoSalida/', 'Solicitudes\SeguimientoController@getDatatableSeguimientoSalida');
    Route::get('datatableDepartamentoSB/{id}', 'Solicitudes\SeguimientoController@getDatatableSeguimientoSB');

});

Route::group(['middleware' => ['auth'],'middleware' => ['role:AdminSolicitudes|SupervisorSolicitud|LiderCC|AdminCC'], 'prefix' => 'adminSolicitudes', 'as' => 'adminSolicitudes.'], function () {
    Route::get('indexAdminLineas', 'Solicitudes\SeguimientoController@indexAdminLineas');
    Route::get('datatableAdministracion/{criterio}/{parametro}/{fechai}/{fechaf}/', 'Solicitudes\SeguimientoController@getDatatableAdministracion');
    Route::post('updateChange', 'Solicitudes\SeguimientoController@updateChange');
    Route::post('deleteChange', 'Solicitudes\SeguimientoController@deleteChange');
    Route::post('editChange', 'Solicitudes\SeguimientoController@editChange');
    Route::get('liberacionAsesor', 'Admin\AdministradorBaseController@indexLiberacionAsesor');
    Route::get('getDatatableLiberacionAsesor/{identificacion}', 'Admin\AdministradorBaseController@getDatatableLiberacionAsesor');
    Route::post('activarAsesor', 'Admin\AdministradorBaseController@activarAsesor');
    Route::get('datatableLinea/{tipo}/{dato}/{celular}', 'Admin\AdministradorBaseController@datatableLinea');

    
});
Route::group(['middleware' => ['auth'],'middleware' => ['role:LiderCredito|LiderCalidad|LiderRecepcion|LiderRegularizacion|AsesorCredito|AsesorCRJ|AsesorCalidad|AsesorRecepcion|AsesorRegularizacion'], 'prefix' => 'liderSeguimiento', 'as' => 'liderSeguimiento.'], function () {
    //-----------Directorio-------------------------------------------------------------------------------------------------------------------
    Route::get('SeguimientoIndex', 'Solicitudes\LiderSeguimientoController@SeguimientoIndex');
    Route::get('datatableDepartamentoS/{dato}/{bandeja}', 'Solicitudes\LiderSeguimientoController@getDatatableSeguimiento');
    Route::get('datatableDepartamentoSalida/', 'Solicitudes\SeguimientoController@getDatatableSeguimientoSalida');
    Route::get('datatableDepartamentoSB/{id}', 'Solicitudes\SeguimientoController@getDatatableSeguimientoSB');

});




