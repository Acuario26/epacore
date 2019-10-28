<?php

namespace App\Core\Entities\Solicitudescj;

use Illuminate\Database\Eloquent\Model;

class RequestPostulant extends Model
{
	    
    protected $connection = 'mysql_solicitudescj';
    protected $table='requests';

    public function state()
	{
		return $this->belongsTo('App\Core\Entities\Solicitudescj\State','state_id','id');
	}

}


