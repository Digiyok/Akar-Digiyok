<?php

namespace App\Models\Rekrutmen;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Jenssegers\Date\Date;

class Spk extends Model
{
    use HasFactory;

    protected $table = "tm_work_agreement";

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Rekrutmen\Pegawai','employee_id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\StatusAktif','status_id');
    }

    public function getPeriodIdAttribute()
    {
        Date::setLocale('id');
        return Date::parse($this->period_start)->format('j F Y').' s.d. '.Date::parse($this->period_end)->format('j F Y');
    }

    public function getRemainingPeriodAttribute()
    {
        $period_end = Date::parse($this->period_end);
        $now = Date::parse(Date::now('Asia/Jakarta')->format('Y-m-d'));
        $date = $period_end->diffInDays($now);

        return $period_end->lessThan($now) ? 'Habis' : $date.' hari';
    }

    public function getEmployeeStatusAcronymAttribute()
    {
        $words = explode(" ", $this->employee_status);
        $acronym = "";

        foreach ($words as $w) {
          $acronym .= $w[0];
        }

        return $acronym;
    }
    
    public function scopeAktif($query){
        return $query->where('status_id',1);
    }
}
