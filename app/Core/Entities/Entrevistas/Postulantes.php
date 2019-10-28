<?php

namespace App\Core\Entities\Entrevistas;

use Illuminate\Database\Eloquent\Model;

class Postulantes extends Model
{
    public $timestamps = true;
    protected $table = 'postulantes';
    protected $connection = 'mysql_entrevista';
    protected $primaryKey = 'celular';
}
