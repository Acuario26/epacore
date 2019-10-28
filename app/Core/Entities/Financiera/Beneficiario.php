<?php

namespace App\Core\Entities\Financiera;

use Illuminate\Database\Eloquent\Model;

class Beneficiario extends Model
{
    public $timestamps = true;
    protected $table = 'beneficiarios';
    protected $connection = 'mysql_modulos';
}
