<?php

namespace App\Core\Entities\Uath;

use Illuminate\Database\Eloquent\Model;

class uath extends Model
{
    public $timestamps = true;
    protected $table = 'uath';
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $fillable = [
        'descripcion',
        'parametro_id',
        'estado',
        'created_at',
        'updated_at',

    ];
}
