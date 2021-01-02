<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function home()
    {
        // return view('tampilan.layouts.app',['pageawal' => TRUE]);
        return view('tampilan.layouts.app')->with('pageawal',TRUE);
    }

    public function index()
    {
        return view('tampilan.index');
    }

    public function masuk(Request $request)
    {
        return redirect('/masuk')->with('errors','Gagal Login, check kembali data yang anda masukan!');
    }
}
