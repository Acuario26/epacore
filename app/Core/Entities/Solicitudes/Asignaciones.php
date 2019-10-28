<?php

namespace App\Core\Entities\Solicitudes;

use Illuminate\Database\Eloquent\Model;

class Asignaciones extends Model
{
    public $timestamps = false;
    protected $table = 'asignaciones';
    protected $connection = 'mysql_solicitudes';
    protected $primaryKey = 'id';

    public function siguiente($departamento,$id){
        return Asignaciones::where('id', '>', $id)
        ->where('departamento_id',$departamento)
        ->orderBy('id', 'asc')->first();
    }
    
    public function previo($departamento,$id){
        
        return Asignaciones::where('id', '<', $id)
        ->where('departamento_id',$departamento)
        ->orderBy('id', 'desc')->first();
    }
}
