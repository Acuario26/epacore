<?php

namespace App\Core\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class tb_parametro extends Model
{
    public $timestamps = true;
    protected $table = 'tb_parametro';
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'descripcion',
                            'parametro_id',
                            'estado',
                            'created_at',
                            'updated_at',
                            'nivel'
    ];
    public function fatherpara(){
        return $this->belongsTo('App\Core\Entities\Admin\tb_parametro','id','parametro_id');
    }

}
