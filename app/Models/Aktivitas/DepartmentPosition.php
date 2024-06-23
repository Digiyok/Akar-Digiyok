<?php

namespace App\Models\Aktivitas;

use App\Models\Penempatan\Jabatan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class DepartmentPosition extends Model
{
  use HasFactory;

  protected $table = "tm_department_Positions";

  function department()
  {
    return $this->belongsTo(Department::class, 'department_id');
  }

  function position()
  {
    return $this->belongsTo(Jabatan::class, 'position_id');
  }
}
