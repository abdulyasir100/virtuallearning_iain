<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClassController extends Controller
{
    //
    public function index(){
        return view('beranda');
    }

    public function show($kodeKelas){
        return view('kelas.kelas',compact('kodeKelas'));
    }
}
