<?php

namespace App\Core\Entities\Entrevistas;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    public $timestamps = true;
    protected $table = 'perfil';
    protected $connection = 'mysql_entrevista';
    protected $primaryKey = 'id';
}
