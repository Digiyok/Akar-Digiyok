<?php

namespace App\Http\Services\Keuangan;

use App\Models\Pembayaran\SppBill;

class SppSiswaService {

    public static function listSppBill($unit_id, $level_id, $month, $year)
    {
        $spp_bills = SppBill::where('year', $year)
            ->when($month, function($q, $month){
                return $q->where('month', $month);
            })
            ->where('unit_id',$unit_id)
            ->when($level_id, function($q, $level_id){
                return $q->where('level_id', $level_id);
            })
            ->get();

        // dd($spp_bills);
        return $spp_bills;
    }

}