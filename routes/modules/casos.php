<?php

Route::middleware(['auth'])->group(function () {


	Route::get('admin/casos', 'Solicitudescj\CasosController@index')
	->name('casos.index');

	Route::get('admin/casos/data', 'Solicitudescj\CasosController@getDatatable')
	->name('casos.data');

	Route::get('admin/casos/{id}/gestion', 'Solicitudescj\CasosController@show')
	->name('casos.show');

	Route::put('admin/casos/{id}/caso', 'Solicitudescj\CasosController@updateCaso')
	->name('casos.updateCaso');

	Route::put('admin/casos/{id}/caso/asesoria', 'Solicitudescj\CasosController@updateCasoAsesoria')
	->name('casos.updateCasoAsesoria');

	Route::put('admin/casos/{id}/caso/Patrocinio', 'Solicitudescj\CasosController@updateCasoPatrocinio')
	->name('casos.updateCasoPatrocinio');

	Route::get('admin/casos/busqueda', 'Solicitudescj\CasosController@search')
	->name('casos.search');

	Route::post('admin/casos/busqueda/fecha', 'Solicitudescj\CasosController@searchPost')
	->name('casos.searchPost');

	Route::get('admin/casos/busqueda/asesorias/{fechaInicio}/{fechaFinal}', 'Solicitudescj\CasosController@searchFechaAsesoria')
	->name('casos.searchFechaAsesoria');

	Route::get('admin/casos/busqueda/patrocionio/{fechaInicio}/{fechaFinal}', 'Solicitudescj\CasosController@searchFechaPatrocinio')
	->name('casos.searchFechaPatrocinio');

	Route::get('admin/casos/busqueda/data/asesoria/{fechaInicio}/{fechaFinal}', 'Solicitudescj\CasosController@searchDataAsesoria')
	->name('casos.searchDataAsesoria');

	Route::get('admin/casos/busqueda/data/patrocinio/{fechaInicio}/{fechaFinal}', 'Solicitudescj\CasosController@searchDataPatrocinio')
	->name('casos.searchDataPatrocinio');

	Route::get('admin/casos/{id}/imprimir', 'Solicitudescj\CasosController@print')
	->name('casos.print');

	Route::get('admin/casos/{id}/imprimir_cedula', 'Solicitudescj\CasosController@printCedula')
	->name('casos.printCedula');

	Route::get('admin/casos/archivo', 'Solicitudescj\CasosController@archivo')
	->name('casos.archivo');

	Route::get('admin/casos/archivo/data', 'Solicitudescj\CasosController@archivoData')
	->name('casos.archivoData');

	Route::get('admin/casos/archivo/subir', 'Solicitudescj\CasosController@archivoSubir')
	->name('casos.archivoSubir');

	Route::post('admin/casos/archivo/guardar', 'Solicitudescj\CasosController@archivoGuardar')
	->name('casos.archivoGuardar');

});
