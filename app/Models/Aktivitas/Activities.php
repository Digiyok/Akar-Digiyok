<?php

namespace App\Models\Aktivitas;

use Jenssegers\Date\Date;
use Illuminate\Support\Carbon;
use App\Models\Rekrutmen\Pegawai;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activities extends Model
{
  use HasFactory;

  protected $table = "tm_activities";

  public function pegawai()
  {
    return $this->belongsTo(Pegawai::class, 'employe_id');
  }

  public function department()
  {
    return $this->belongsTo(Department::class, 'department_id');
  }

  public function status()
  {
    return $this->belongsTo(ActivityStatus::class, 'status_id');
  }

  // image
  public function getImagePathAttribute()
  {
    if ($this->image) return 'img/aktivitas/' . $this->image;
    else return null;
  }

  public function getShowImageAttribute()
  {
    return File::exists($this->imagePath) ? $this->imagePath : 'img/avatar/default.png';
  }

  public function getAvatarAttribute()
  {
    return '<div class="avatar-md">'
      . '<img src="' . asset($this->showImage) . '" alt="service-' . $this->id . '" class="avatar-img">'
      . '</div>';
  }

  public function getNameWithImageAttribute()
  {
    return $this->image . $this->name;
  }

  public function getFormattedStartDateAttribute()
  {
    return Carbon::parse($this->attributes['start_date'])
      ->locale('id')
      ->translatedFormat('d F Y');
  }

  public function getFormattedEndDateAttribute()
  {
    return Carbon::parse($this->attributes['end_date'])
      ->locale('id')
      ->translatedFormat('d F Y');
  }
}
