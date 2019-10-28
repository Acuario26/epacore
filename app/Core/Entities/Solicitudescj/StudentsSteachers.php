<?php

namespace App\Core\Entities\Solicitudescj;

use Illuminate\Database\Eloquent\Model;

class StudentsSteachers extends Model
{
        protected $connection = 'mysql_solicitudescj';

        protected $table='students_teachers';


    public function docente()
	{
		return $this->belongsTo('App\User','user_doc_id','id');
	}

	public function horario()
	{
		return $this->belongsTo('App\Core\Entities\Solicitudescj\Horario','horario_id','id');
	}

	public function lugar()
	{
		return $this->belongsTo('App\Core\Entities\Solicitudescj\Place','lugar_id','id');
	}

}
