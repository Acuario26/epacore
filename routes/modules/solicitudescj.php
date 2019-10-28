<?php

Route::get('admin/estudianteperfil', 'Solicitudescj\StudentController@estudianteperfil')->name('admin.estudianteperfil');
Route::post('registroP', 'Solicitudescj\RegistroController@registroP')->name('registroP');
Route::post('registroPP', 'Solicitudescj\RegistroController@registroPP')->name('registroPP');
Route::post('admin/estudianteasigna', 'Solicitudescj\StudentController@estudianteasigna')->name('admin.estudianteasignacion');

Route::post('supervisor', 'Solicitudescj\StudentController@supervisor');
Route::post('semanaEstudiaante', 'Solicitudescj\DocenteController@semanaEstudiaante');
Route::get('estudiante/actividadesEstudiante', 'Solicitudescj\StudentController@actividadesEstudiante')
->name('estudiante.actividadesEstudiante');
Route::get('datatableasistencias', 'Solicitudescj\StudentController@getDatatableAsistencia');
Route::get('datatablesemanas', 'Solicitudescj\StudentController@getDatatablesemanas');
Route::get('datatableObservaciones', 'Solicitudescj\DocenteController@getDatatableObservaciones');
Route::get('admin/estudianteperfil', 'Solicitudescj\StudentController@estudianteperfil')->name('admin.estudianteperfil');
Route::get('semanaImprime/{semana}', 'Solicitudescj\StudentController@semanaImprime')->name('student.semanaImprime');
Route::get('agregaActividad/{id}', 'Solicitudescj\StudentController@agregaActividad')->name('student.agregaActividad');
Route::post('estudiante/actividadSave', 'Solicitudescj\StudentController@actividadSave')->name('estudiante.actividadSave');
Route::get('supervisor/asistencia', 'Solicitudescj\DocenteController@index')
->name('supervisor.asistencia');	
Route::get('datatableAsistencia', 'Solicitudescj\DocenteController@datatableAsistencia');
Route::post('supervisor/asistenciaSave', 'Solicitudescj\DocenteController@asistenciaSave')->name('supervisor.asistenciaSave');
Route::post('supervisor/observacionSave', 'Solicitudescj\DocenteController@observacionSave')
->name('supervisor.observacionSave');
Route::get('StateActividad/{id}', 'Solicitudescj\DocenteController@StateActividad')->name('docente.stateactividad');


Route::get('estudiante/clinica', 'Solicitudescj\StudentController@Clinica')->name('student.clinica');
Route::post('/upload', 'StorageController@fotosClinica');

Route::post('/DeleteFoto', 'StorageController@DeleteFoto')->name('student.deleteFoto');;

Route::get('estudiante/evaluacion', 'Solicitudescj\StudentController@indexEvaluacion')->name('student.indexEvaluacion');
Route::get('estudiante/evaluacionI', 'Solicitudescj\StudentController@evaluacion')->name('student.evaluacion');
Route::get('datatableEvaluacionesEstudiante', 'Solicitudescj\StudentController@datatableEvaluacionesEstudiante');
Route::get('datatableClinica', 'Solicitudescj\DirectoraController@datatableClinica');

Route::get('clinica/ClinicaIndex', 'Solicitudescj\DirectoraController@ClinicaIndex')->name('clinica.ClinicaIndex');
Route::get('ClinicaFotos/{id}', 'Solicitudescj\DirectoraController@ClinicaFotos')->name('clinica.ClinicaFotos');


Route::get('tutor/evaluacionSupervision', 'Solicitudescj\DocenteController@evaluacionSupervision')->name('tutor.evaluacionSupervision');
Route::get('datatableEvaluacionesTutor', 'Solicitudescj\DocenteController@datatableEvaluacionesTutor');
Route::post('tutor/evaluacionSave', 'Solicitudescj\DocenteController@evaluacionSave')
->name('tutor.evaluacionSave');
Route::post('student/evaluacionSave', 'Solicitudescj\StudentController@evaluacionSave')
->name('student.evaluacionSave');
Route::post('imprimirAsistencia', 'Solicitudescj\DocenteController@imprimirAsistencia')->name('imprimirAsistencia');
Route::get('imprimirEvaluacion/{id}', 'Solicitudescj\DocenteController@imprimirEvaluacion')->name('tutor.imprimirEvaluacion');
Route::get('plantillaficha', 'Solicitudescj\StudentController@imprimirFicha')->name('student.imprimirFicha');
Route::get('/supervisor/evaluacionDesempeño', 'Solicitudescj\DocenteController@evaluacionDesempeño')->name('supervisor.evaluacionDesempeño');
Route::get('datatableEvaluacionesSup', 'Solicitudescj\DocenteController@datatableEvaluacionesSup');
Route::post('supervisor/evaluacionSupSave', 'Solicitudescj\DocenteController@evaluacionSupSave')
->name('supervisor.evaluacionSupSave');
Route::get('imprimirEvaluacionSup/{id}', 'Solicitudescj\DocenteController@imprimirEvaluacionSup')->name('supervisor.imprimirEvaluacionSup');
Route::get('UserState/{id}', 'Admin\UsersController@userstate')
->name('admin.userstate');


Route::get('datatableEvaluacionesSupEst', 'Solicitudescj\StudentController@datatableEvaluacionesSup');
Route::get('imprimirEvaluacionStudent/{id}', 'Solicitudescj\StudentController@imprimirEvaluacion')->name('student.imprimirEvaluacion');
Route::get('student/evaluacionSupervisor', 'Solicitudescj\StudentController@evaluacionSupervisor')->name('student.evaluacionSupervisor');
Route::get('datatableEvaluacionesTutorEst', 'Solicitudescj\StudentController@datatableEvaluacionesTutorEst');


Route::get('admin/placeIndex', 'Solicitudescj\DirectoraController@placeIndex')->name('admin.placeIndex');
Route::get('datatableLugares', 'Solicitudescj\DirectoraController@datatableLugares');
Route::get('adminEditarLugares/{id}', 'Solicitudescj\DirectoraController@editarLugares')->name('admin.editarLugares');
Route::post('saveLugar', 'Solicitudescj\DirectoraController@saveLugar');
Route::get('adminNuevoLugar/', 'Solicitudescj\DirectoraController@crearLugar')->name('admin.crearLugar');

Route::get('all/procesoFinal', 'Solicitudescj\DirectoraController@procesoFinal')->name('all.procesoFinal');
Route::get('datatableAllFinal', 'Solicitudescj\DirectoraController@datatableAllFinal');
Route::get('allaprobarPdf/{id}', 'Solicitudescj\DirectoraController@aprobarPdf')->name('all.aprobarPdf');
Route::post('allnegarPdf', 'Solicitudescj\DirectoraController@negarPdf')->name('all.negarPdf');
Route::post('/uploadFinal', 'Solicitudescj\DirectoraController@uploadFinal');

Route::get('all/checkout', 'Solicitudescj\DirectoraController@checkout')->name('all.checkout');
Route::get('datatablecheckout', 'Solicitudescj\DirectoraController@datatablecheckout');
Route::get('editarcheckout/{id}', 'Solicitudescj\DirectoraController@editarcheckout')->name('all.editarcheckout');
Route::post('savecheckout', 'Solicitudescj\DirectoraController@savecheckout');
Route::get('addCheckout/', 'Solicitudescj\DirectoraController@addCheckout')->name('all.addCheckout');
Route::post('saveAsistenciaD', 'Solicitudescj\DocenteController@saveAsistenciaD')->name('d.saveEditAsistencia');


Route::get('removeAsistenciaD/{id}', 'Solicitudescj\DocenteController@removeAsistenciaD')->name('docente.removeAsistenciaD');

Route::get('editAsistenciaD/{id}', 'Solicitudescj\DocenteController@editAsistenciaD')->name('docente.editAsistenciaD');

