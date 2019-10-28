<?php

namespace App\Core\Entities\Solicitudescj;

use Illuminate\Database\Eloquent\Model;

class ProductsPhoto extends Model
{
    protected $connection = 'mysql_solicitudescj';

    protected $fillable = ['user_id', 'filename'];
 

}
