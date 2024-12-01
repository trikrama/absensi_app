<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManajemenTugasController extends Controller
{
    //
    public function index()
    {
        return view('manajemen_tugas.upload_tugas');
    }

    public function Kunjungan(Request $request){
        return view('manajemen_tugas.kunjungan');
    }
}
