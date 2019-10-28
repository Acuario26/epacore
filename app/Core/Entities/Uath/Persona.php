<?php

namespace App\Core\Entities\Uath;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    public $timestamps = true;
    protected $table = 'persona';
    protected $connection = 'mysql_uath';
    protected $primaryKey = 'identificacion';
}
