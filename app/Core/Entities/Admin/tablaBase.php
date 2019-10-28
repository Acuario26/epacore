<?php

namespace App\Core\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class tablaBase extends Model
{
    public $timestamps = false;
    protected $table = 'tablaBase';
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
}
