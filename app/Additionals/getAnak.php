<?php

namespace App\Additionals;

use App\Http\Controllers\Controller;
use App\Models\Siswa\CalonSiswa;
use Illuminate\Http\Request;

class getAnak
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function listAnak($parent_id )
    {
        $anak = CalonSiswa::where('parent_id',$parent_id)->orderBy('created_at','DESC')->get();
        return $anak;
    }
}
