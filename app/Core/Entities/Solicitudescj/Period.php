<?php

namespace App\Core\Entities\Solicitudescj;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    
    protected $connection = 'mysql_solicitudescj';

    protected $table = 'periodos';

    protected $append = ['estado_label'];

    public function getEstadoLabelAttribute(){

        $label='<span class="label label-default label-many">Sin definir</span> ';

        if($this->estado=='A'){
            $label='<span class="label label-success label-many">Activo</span> ';
        }elseif($this->estado=='I'){
            $label='<span class="label label-danger label-many">Bloqueado</span> ';
        }

        return $label;
    }

}
