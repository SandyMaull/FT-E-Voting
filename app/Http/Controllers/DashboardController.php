<?php

namespace App\Http\Controllers;

use App\Helpers\CustomHelper;
use App\Kandidat;
use App\Tim;
use App\Voters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Intervention\Image\Facades\Image;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('votingcheck')->except('home');
        $this->middleware('verifvoters', ['only' => [
            'beranda'
        ]]);
    }

    public function home()
    {
        // return view('tampilan.layouts.app',['pageawal' => TRUE]);
        return view('tampilan.layouts.app')->with('pageawal',TRUE);
    }

    public function register_index()
    {
        return view('tampilan.register');
    }

    public function register_post(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required|max:2048',
            'prodi' => 'required',
            'password' => 'required|min:8',
            'telp' => 'required',
            'siakadfoto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ],
        [
            'nama.required' => 'Kolom Nama dibutuhkan!',
            'nim.required' => 'Kolom NIM dibutuhkan!',
            'nim.max' => 'Isi kolom NIM dgn Benar!',
            'prodi.required' => 'Kolom Prodi dibutuhkan!',
            'password.required' => 'Kolom Password dibutuhkan!',
            'password.min' => 'Password minimal 8 digit!',
            'telp.required' => 'Kolom Telp dibutuhkan!',
            'siakadfoto.required' => 'Foto Siakad dibutuhkan!',
            'siakadfoto.max' => 'Foto Siakad maximal size 2MB!',
        ]);
        $helper_nim = CustomHelper::UniqueVoters('nim',$request->nim);
        $helper_telp = CustomHelper::UniqueVoters('nmor_wa', $request->telp);
        if ($helper_nim && $helper_telp) {
            $token = mt_rand(100000, 999999);
            $helper_token = CustomHelper::UniqueVoters('token', $request->token);
            if (!$helper_token) {
                $token = mt_rand(100000, 999999);
            }
            if($file = $request->file('siakadfoto')) {
                $name = Carbon::now()->timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/image/siakad');
                if($file->move($destinationPath, $name)) {
                    $voter = new Voters;
                    $voter->nama = $request->nama;
                    $voter->nim = $request->nim;
                    $voter->prodi = $request->prodi;
                    $voter->token = $token;
                    $voter->password = Hash::make($request->password);
                    $voter->nmor_wa = $request->telp;
                    $voter->foto_siakad = $name;
                    $voter->has_vote = 0;
                    $voter->verified = 0;
                    $voter_save = $voter->save();
                    if ($voter_save) {
                        return redirect('/masuk')->with('afterregis', $token);
                    }
                    else {
                        return redirect()->route('register')->with(['status' => 'error','message' => ' Data Gagal Ditambah! Check Database Connection.']);
                    }
                }
                else {
                    return redirect()->route('register')->with(['status' => 'error','message' => ' Data Gagal Ditambah! Check File Permission.']);
                }
            }
            else {
                return redirect()->route('register')->with(['status' => 'error','message' => ' Data Gagal Ditambah! Check Format Gambar yg dikirim.']);
            }
        }
        else {
            return redirect()->route('register')->with(['status' => 'error','message' => ' Data Gagal Ditambah! Check NIM dan No.Telp.']);
        }
    }

    public function beranda()
    {
        $tim = Tim::all();
        $kandidat = Kandidat::all();
        return view('tampilan.beranda', ['tim' => $tim, 'kandidat' => $kandidat]);
    }
}
