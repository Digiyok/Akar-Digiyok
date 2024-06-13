<?php

namespace App\Models\Aktivitas;

use App\Models\Penempatan\Jabatan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Jenssegers\Date\Date;

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
    return $this->belongsTo('app\Models\Penempatan\Jabatan.php', 'position_id');
  }
}
