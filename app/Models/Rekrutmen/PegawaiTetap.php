<?php

namespace App\Models\Rekrutmen;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Jenssegers\Date\Date;

class PegawaiTetap extends Model
{
    use HasFactory;

    protected $table = "tm_permanent_employee";

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Rekrutmen\Pegawai','employee_id');
    }

    public function getPromotionDateIdAttribute()
    {
        Date::setLocale('id');
        return Date::parse($this->promotion_date)->format('j F Y');
    }
}
