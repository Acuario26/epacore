<?php

Route::middleware(['auth'])->group(function () {


	Route::get('admin/gestion/pasantes', 'Solicitudescj\PassantsController@index')
	->name('passants.index');

	Route::get('admin/gestion/pasantes/data', 'Solicitudescj\PassantsController@getDatatable')
	->name('passants.data');

	Route::get('admin/gestion/pasantes/consulta/supervisor','Solicitudescj\PassantsController@consultaSupervisor')
	->name('passants.consultaSupervisor');

	Route::get('admin/gestion/pasantes/consulta/supervisor/elegido/{id}','Solicitudescj\PassantsController@selectSupervisor')
	->name('passants.selectSupervisor');

	Route::get('admin/gestion/pasantes/{id}/gestion', 'Solicitudescj\PassantsController@show')
	->name('passants.show');

	Route::post('admin/gestion/pasantes/guardar-tutor', 'Solicitudescj\PassantsController@assignSteacherTutor')
	->name('passants.assignSteacherTutor');

	Route::post('admin/gestion/pasantes/guardar-supervisor', 'Solicitudescj\PassantsController@assignSteacherSupervisor')
	->name('passants.assignSteacherSupervisor');

	Route::get('admin/gestion/pansantes/supervisor/{id}/activar', 'Solicitudescj\PassantsController@activarSupervisor')
	->name('passants.activarSupervisor');


	Route::post('admin/gestion/pasantes/rechazo', 'Solicitudescj\PassantsController@statusRejection')
	->name('passants.statusRejection');

	Route::post('admin/gestion/pasantes/activar', 'Solicitudescj\PassantsController@statusActivar')
	->name('passants.statusActivar');

	Route::get('admin/gestion/pasantes/{id}/imprimir-asignacion-tutor', 'Solicitudescj\PassantsController@printPlanillaTutor')
	->name('passants.printPlanillaTutor');

	Route::get('admin/gestion/pasantes/{id}/imprimir-asignacion-supervisor', 'Solicitudescj\PassantsController@printPlanillaSupervisor')
	->name('passants.printPlanillaSupervisor');

});

	