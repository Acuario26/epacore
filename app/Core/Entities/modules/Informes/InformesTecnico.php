<?php

namespace App\Core\Entities\modules\Informes;

use Illuminate\Database\Eloquent\Model;

class InformesTecnico extends Model
{
    protected $table = 'informestecnicos';
    protected $connection = 'mysql_modulos';
}
