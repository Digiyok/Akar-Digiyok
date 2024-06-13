<?php

namespace App\Http\Controllers\Akun;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Session;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('akun.profil_index');
    }
}
