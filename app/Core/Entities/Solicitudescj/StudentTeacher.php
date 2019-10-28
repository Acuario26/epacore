<?php

namespace App\Core\Entities\Solicitudescj;

use Illuminate\Database\Eloquent\Model;

class StudentTeacher extends Model
{
            protected $connection = 'mysql_solicitudescj';
			protected $table = 'students_teachers';


}
