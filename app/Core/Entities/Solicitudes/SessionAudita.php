<?php

namespace App\Core\Entities\Solicitudes;

use Illuminate\Database\Eloquent\Model;

class SessionAudita extends Model
{
    public $timestamps = true;
    protected $table = 'SessionAudita';
    protected $connection = 'mysql_solicitudes';
    protected $primaryKey = 'id';

}
