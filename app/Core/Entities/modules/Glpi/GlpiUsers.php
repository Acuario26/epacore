<?php

namespace App\Core\Entities\modules\Glpi;

use Illuminate\Database\Eloquent\Model;

class GlpiUsers extends Model
{
    protected $table = 'glpi_users';
    protected $connection = 'mysql_GLPI';
}
