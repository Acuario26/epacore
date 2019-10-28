<?php

Route::get('/firma/index', 'Admin\FirmaController@index');


Route::get('/PDF', function () { 

$pdf = \PDF::loadView('frontend/datosimprimir');
return $pdf->stream();
})->name('frontend.pdf');

 Route::get('/plantilla', function () { 
    $obj=\DB::connection('mysql_solicitudescj')
    ->table('periodos')->where('estado','A')->get()->first();

    $cc=\DB::connection('mysql_solicitudescj')
    ->table('periodos')->where('estado','A')->where('habilita','A')->get()->count();
    
    return view('frontend/datos')->with(['obj'=>$obj,'cc'=>$cc]);;
 })->name('frontend.datos');
   

 Route::get('/plantillaImprime', function () { 
    return view('frontend/datosimprimir');
 })->name('frontend.imprimir');

 Route::get('/', function () { 
   return redirect('/login');
 })->name('administracion');
 
Route::post('storage/create', 'StorageController@save')->name('storage.create');
Route::get('formulario', 'StorageController@index');
Route::get('storage/{archivo}', function ($archivo) {
     $public_path = public_path();
     $url = $public_path.'/storage/'.$archivo;
     //verificamos si el archivo existe y lo retornamos
     if (Storage::exists($archivo))
     {
       return response()->download($url);
     }
     //si no se encuentra lanzamos un error 404.
     abort(404);
 
});
// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
$this->post('login', 'Auth\LoginController@login')->name('auth.login');
$this->post('logout', 'Auth\LoginController@logout')->name('auth.logout');

//Editar Perfil


// Change Password Routes...
$this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
$this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');


Route::get('admin/home', 'HomeController@index');
Route::post('admin/sessionAudita', 'HomeController@sessionAudita');

Route::group(['middleware' => ['auth'],'middleware' => ['role:administrator'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    //-----------Parametros-------------------------------------------------------------------------------------------------------------------
    Route::get('ParametroIndex', 'Admin\ParametroController@index')->name('parametro.create');
    Route::post('SaveParameter', 'Admin\ParametroController@SaveParameter');
    Route::post('ParameterEliminar', 'Admin\ParametroController@ParameterEliminar');
    Route::get('datatable-parameter/', 'Admin\ParametroController@getDatatable');

    //----------Opciones--------------------------------------------------------------------------------------------------------------------
    Route::post('SaveOpcion', 'Admin\MenuController@StoreOpcion');
    Route::post('MenuEliminar', 'Admin\MenuController@MenuEliminar');
    Route::get('datatable-menu/', 'Admin\MenuController@getDatatable');
    Route::get('datatable-option/', 'Admin\MenuController@getDatatableoption');
    //-------------Roles_Opciones-----------------------------------------------------------------------------------------------------------------

    Route::get('MenuCreate', 'Admin\MenuController@index')->name('menu.create');
    Route::post('MenuRoleEliminar', 'Admin\MenuController@MenuRoleEliminar');
    Route::post('/PermissionRole/', 'Admin\MenuController@PermissionRole');
    Route::post('/UpdateRoleP/', 'Admin\RolesController@UpdateRoleP');
    //------------------------------------------------------------------------------------------------------------------------------
    //Route::resource('permissions', 'Admin\PermissionsController');
   // Route::post('permissions_mass_destroy', ['uses' => 'Admin\PermissionsController@massDestroy', 'as' => 'permissions.mass_destroy']);
    Route::resource('roles', 'Admin\RolesController');
    Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    Route::resource('users', 'Admin\UsersController');
    Route::post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);

    //---------Administrador de Base-------------------------------------------------------------------------------------------------

    Route::get('AdminBaseIndex', 'Admin\AdministradorBaseController@AdminBaseIndex');
    Route::post('AdminBaseStore', 'Admin\AdministradorBaseController@AdminBaseStore');

});
