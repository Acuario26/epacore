<?php

Route::middleware(['auth'])->group(function () {


Route::get('admin/gestion/empleados', 'Solicitudescj\EmployeeController@index')
	->name('employees.index');

	Route::get('admin/gestion/empleados/data', 'Solicitudescj\EmployeeController@getDatatable')
	->name('employees.data');

	Route::get('admin/gestion/{id}/empleados', 'Solicitudescj\EmployeeController@show')
	->name('employees.show');

	Route::get('admin/gestion/empleados/agregar', 'Solicitudescj\EmployeeController@create')
	->name('employees.create');

	Route::post('admin/gestion/empleados/guardar', 'Solicitudescj\EmployeeController@store')
	->name('employees.store');

	Route::put('admin/gestion/{id}/empleados/editar', 'Solicitudescj\EmployeeController@update')
	->name('employees.update');

});