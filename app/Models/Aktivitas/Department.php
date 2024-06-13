<?php

namespace App\Models\Aktivitas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Jenssegers\Date\Date;

class Department extends Model
{
  use HasFactory;

  protected $table = "tm_departments";

  function departmentPosition()
  {
    return $this->hasMany(DepartmentPosition::class, 'department_id');
  }
}
