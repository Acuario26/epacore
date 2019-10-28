<?php

namespace App\Core\Entities\Solicitudescj;

use Illuminate\Database\Eloquent\Model;

class Postulant extends Model
{
    protected $connection = 'mysql_solicitudescj';
    protected $append = ['status_label', 'created_at_es', 'status_request', 'status_abv'];
	
	public function career()
	{
		return $this->belongsTo('App\Core\Entities\Solicitudescj\Career','career_id','id');
	}

	public function request()
	{
		return $this->belongsTo('App\Core\Entities\Solicitudescj\RequestPostulant','id','postulant_id');
	}

	public function getStatusLabelAttribute(){


		switch($this->request->state->abv)
		{
			case 'AU':
			return '<p class="label label-info">'.$this->request->state->descripcion.'<p>';

			break;
			case 'AP':
			$user=\App\User::where('persona_id',$this->identificacion)->first();
			$end=\App\Core\Entities\Solicitudescj\End::where('user_id',$user->id)->where('estado','A')->get();
			

			if(count($end)>0){
				return '<span class="label label-success">'.$this->request->state->descripcion.'</span> '.'<span class="label label-default">Finalidado</span>' ;				
			}else{
				return '<p class="label label-success">'.$this->request->state->descripcion.'<p>';
			}

			break;
			case 'NE':
			return '<p class="label label-default">'.$this->request->state->descripcion.'<p>';

			break;
			case 'AB':
			return '<p class="label label-default">'.$this->request->state->descripcion.'<p>';

			break;
			case 'PE':
			return '<p class="label label-warning">'.$this->request->state->descripcion.'<p>';

			break;
			case 'AUI':
				return '<p class="label label-danger">'.$this->request->state->descripcion.'<p>';

			break;
		
		}
	}

	public function getStatusRequestAttribute(){
		return $this->request->state->descripcion;
	}

	public function getStatusAbvAttribute(){
		return $this->request->state->abv;
	}

	public function getCreatedAtEsAttribute(){
		return $this->created_at->format('d-m-Y');
	}
}

