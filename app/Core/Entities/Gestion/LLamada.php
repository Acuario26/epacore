<?php

namespace App\Core\Entities\Gestion;

use Illuminate\Database\Eloquent\Model;

class LLamada extends Model
{
    public $timestamps = false;

    protected $connection = 'mysql_recaudaciones';
    protected $table = 'llamadas';


}
