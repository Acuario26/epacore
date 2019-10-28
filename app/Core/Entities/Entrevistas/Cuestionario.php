<?php

namespace App\Core\Entities\Entrevistas;

use Illuminate\Database\Eloquent\Model;

class Cuestionario extends Model
{
    public $timestamps = true;
    protected $table = 'cuestionario';
    protected $connection = 'mysql_entrevista';
    protected $primaryKey = 'id';
}
