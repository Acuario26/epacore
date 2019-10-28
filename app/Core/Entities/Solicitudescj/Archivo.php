<?php

namespace App\Core\Entities\Solicitudescj;

use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
	protected $connection = 'mysql_solicitudescj';
	
    protected $table = 'archivos';

}