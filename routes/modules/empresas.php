<?php

Route::group(['prefix' => 'empresa', 'as' => 'empresa.'], function () {

    Route::get('empresaIndex', 'Admin\EmpresaController@index')->name('empresaIndex');

  });
  