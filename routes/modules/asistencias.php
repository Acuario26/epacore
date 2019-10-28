<?php

Route::middleware(['auth'])->group(function () {

	Route::get('admin/monitor/asistencia', 'Solicitudescj\AsistenciaController@index')
	->name('monitor.asistencia');	

	Route::get('datatableAsistenciaMonitor', 'Solicitudescj\AsistenciaController@datatableAsistencia')->name('monitor.datatableAsistencia');

	Route::post('admin/monitor/asistenciaSave', 'Solicitudescj\AsistenciaController@asistenciaSave')
	->name('monitor.asistenciaSave');

});