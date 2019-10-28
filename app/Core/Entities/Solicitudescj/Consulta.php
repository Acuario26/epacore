<?php

namespace App\Core\Entities\Solicitudescj;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
	protected $connection = 'mysql_solicitudescj';
	protected $append = ['created_at_es', 'created_at_en','cjga','mes','fecha_asesoria','annio','provincia','ciudad', 'cliente_nombre', 'practicante_nombre', 'observacion' ];

    protected $table = 'consultas';



    public function supervisor()
	{
		return $this->belongsTo('App\User','supervisor_id','id');
	}

    public function practicante()
    {
        return $this->belongsTo('App\User','practicante_id','id');
    }

	public function cliente()
	{
		return $this->belongsTo('App\Core\Entities\Solicitudescj\Client','cliente_id','id');
	}

	public function getCreatedAtEsAttribute(){
		return $this->created_at->format('d-m-Y');
	}

	public function getCreatedAtEnAttribute(){
		return $this->created_at->format('d-m-Y');
	}


	public function getEstadoLabelAttribute(){

    	$label='';

        $label='<span class="label label-default label-many">Sin definir</span> ';

        if($this->estado=='A'){
            $label='<span class="label label-success label-many">Activo</span> ';
        }elseif($this->estado=='I'){
            $label='<span class="label label-danger label-many">Bloqueado</span> ';
        }elseif($this->estado=='P'){
            $label='<span class="label label-warning label-many">Pendiente</span> ';
        }elseif($this->estado=='AT'){
            $label='<span class="label label-success label-many">Atendido</span> ';
        }elseif($this->estado=='F'){
            $label='<span class="label label-success label-many">Finalizado</span> ';
        }elseif($this->estado=='PI'){
            $label='<span class="label label-warning label-many">Pendiente</span> ';
        }

        return $label;
    }

    public function getCjgaAttribute(){
        return 'FACULTAD DE JURIPRUDENCIA Y CIENCIAS SOCIALES Y POLITICAS UNIVERSIDAD DE GUAYAQUIL';
    }

    public function getMesLabelAttribute(){
        $mes = $this->created_at->format('m');
        if($mes=='01'){
          return 'Enero';
        }elseif($mes=='02'){
          return 'Febrero';
        }elseif($mes=='03'){
          return 'Marzo';
        }elseif($mes=='04'){
          return 'Abril';
        }elseif($mes=='05'){
          return 'Mayo';
        }elseif($mes=='06'){
          return 'Junio';
        }elseif($mes=='07'){
          return 'Julio';
        }elseif($mes=='08'){
          return 'Agosto';
        }elseif($mes=='09'){
          return 'Septiembre';
        }elseif($mes=='10'){
          return 'Octubre';
        }elseif($mes=='11'){
          return 'Noviembre';
        }elseif($mes=='12'){
          return 'Diciembre';
        }

        return '';
    }

    public function getFechaAsesoriaAttribute(){
        return $this->created_at->format('Y');
    }

    public function getAnnioAttribute(){
        return $this->created_at->format('Y');
    }

    public function getProvinciaAttribute(){
        return 'Guayas';
    }

    public function getCiudadAttribute(){
        return 'Guayaquil';
    }

    public function getClienteNombreAttribute(){
        return $this->cliente->nombres.' '.$this->cliente->apellidos; 
    }

    public function getPracticanteNombreAttribute(){
        return $this->practicante ? $this->practicante->name : 'sin practicante';
    }

    public function getObservacionAttribute(){
        return $this->detalle.' | '.$this->practicante_nombre;
    }




}	
