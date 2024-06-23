<?php

namespace App\Models\Aktivitas;

use Jenssegers\Date\Date;
use Illuminate\Support\Facades\File;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityStatus extends Model
{
  use HasFactory;

  protected $table = "tref_activities_status";

  public function activity()
  {
    return $this->hasOne(Activities::class, 'status_id');
  }
}
