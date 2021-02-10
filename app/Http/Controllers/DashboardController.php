<?php

namespace App\Http\Controllers;

use App\Helpers\CustomHelper;
use App\Kandidat;
use App\Tervote;
use App\Tim;
use App\Voters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('votingcheck')->except('home', 'resultakhir');
        $this->middleware('guestvoters', ['only' => [
            'register_index', 'register_post', 'redirectLoginAfterRegis'
        ]]);
        $this->middleware('verifvoters', ['only' => [
            'beranda', 'pilihbem', 'pilihdpm'
        ]]);
    }

    public function home()
    {
        return view('tampilan.layouts.app')->with('pageawal',TRUE);
    }

    public function resultakhir()
    {
        // $tim_bem = Tim::where('pemilihan', 'BEM')->get();
        $dpmvotesdb = Kandidat::where('tim_id', 11)->get();
        $looping = 1;
        foreach ($dpmvotesdb as $dpm) {
            $dpmtervote = Tervote::where('voting_dpm', $dpm->id)->count();
            if ($dpmtervote) {
                $colors = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
                $dpmvotesdata[$dpm->id] = [
                    'nama' => $dpm->nama . ' - ' . $dpm->jurusan,
                    'vote' => $dpmtervote,
                    'colors' => $colors,
                ];
            } else {
                $colors = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
                $dpmvotesdata[$dpm->id] = [
                    'nama' => $dpm->nama . ' - ' . $dpm->jurusan,
                    'vote' => 0,
                    'colors' => $colors,
                ];
            }
            $looping += 1;
        }
        // dd($dpmvotesdata);
        return view('tampilan.result', ['dpmdata' => json_encode($dpmvotesdata)]);
    }

    public function register_index()
    {
        return view('tampilan.register');
    }

    public function register_post(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required|max:13|min:13',
            'prodi' => 'required',
            'password' => 'required|min:8',
            'telp' => 'required',
            'siakadfoto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ],
        [
            'nama.required' => 'Kolom Nama dibutuhkan!',
            'nim.required' => 'Kolom NIM dibutuhkan!',
            'nim.max' => 'Isi kolom NIM dgn Benar! Contoh format NIM yang sesuai: 17.01.071.106',
            'nim.min' => 'Isi kolom NIM dgn Benar! Contoh format NIM yang sesuai: 17.01.071.106',
            'prodi.required' => 'Kolom Prodi dibutuhkan!',
            'password.required' => 'Kolom Password dibutuhkan!',
            'password.min' => 'Password minimal 8 digit!',
            'telp.required' => 'Kolom Telp dibutuhkan!',
            'siakadfoto.required' => 'Foto Siakad dibutuhkan!',
            'siakadfoto.max' => 'Foto Siakad maximal size 2MB!',
        ]);
        $helper_nim = CustomHelper::UniqueVoters($request->nim, 'nim');
        $helper_telp = CustomHelper::UniqueVoters($request->telp, 'nmor_wa');
        if ($helper_nim && $helper_telp) {
            $token = mt_rand(100000, 999999);
            $helper_token = CustomHelper::UniqueVoters($token, 'token');
            while(!$helper_token) {
                $token = mt_rand(100000, 999999);
                $helper_token = CustomHelper::UniqueVoters($token, 'token');
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

    public function redirectLoginAfterRegis($token)
    {
        $voters = Voters::where('token', $token)->first();
        if ($voters) {
            return redirect('/masuk')->with('openlink', $token);
        }
        else {
            return redirect('/masuk');
        }
    }
    // BERANDAROUTE 
        // public function beranda()
        // {
        //     $tim_bem = Tim::where('pemilihan', 'BEM')->get();
        //     $tim_dpm = Tim::where('pemilihan', 'DPM')->get();
        //     $kandidat = Kandidat::all();
        //     return view('tampilan.beranda', ['tim_dpm' => $tim_dpm, 'tim_bem' => $tim_bem, 'kandidat' => $kandidat])->with('bem', TRUE);
        // }

    public function beranda()
    {
        $tim_dpm = Tim::where('pemilihan', 'DPM')->get();
        $kandidat = Kandidat::all();
        return view('tampilan.beranda2', ['tim_dpm' => $tim_dpm, 'kandidat' => $kandidat])->with('dpm', TRUE);
    }
    // PILIHBEMROUTE 
        // public function pilihbem(Request $request)
        // {
        //     $request->validate([
        //         'pilihan' => 'required',
        //         'pemilihID' => 'required',
        //     ],
        //     [
        //         'pilihan.required' => 'ERROR, PILIHAN ID TIDAK DAPAT DI COLLECT OLEH SISTEM!',
        //         'pemilihID.required' => 'ERROR, PEMILIH ID TIDAK DAPAT DI COLLECT OLEH SISTEM!',
        //     ]);
        //     $bemvote = $request->pilihan;
        //     $votersID = $request->pemilihID;
        //     return redirect(route('beranda'))->with(['bemvote' => $bemvote, 'votersID' => $votersID, 'dpm' => TRUE, 'bem' => FALSE]);
        // }
    // PILIHDPMROUTE 
        // public function pilihdpm(Request $request)
        // {
        //     $request->validate([
        //         'bemvote' => 'required',
        //         'pilihan' => 'required',
        //         'pemilihID' => 'required',
        //     ],
        //     [
        //         'bemvote.required' => 'ERROR, BEMVOTE TIDAK DAPAT DI COLLECT OLEH SISTEM!',
        //         'pilihan.required' => 'ERROR, PILIHAN ID TIDAK DAPAT DI COLLECT OLEH SISTEM!',
        //         'pemilihID.required' => 'ERROR, PEMILIH ID TIDAK DAPAT DI COLLECT OLEH SISTEM!',
        //     ]);
        //     $finalvote = new Tervote;
        //     $finalvote->tim_id = $request->bemvote;
        //     $finalvote->voting_dpm = $request->pilihan;
        //     $finalvote->voters_id = $request->pemilihID;
        //     $savevote = $finalvote->save();

        //     $hasvote = Voters::where('id', $request->pemilihID)->first();
        //     $votersudpate = $hasvote->update([
        //         'has_vote' => 1,
        //     ]);

        //     if($savevote && $votersudpate) {
        //         return redirect(route('aftervote'))->with('pageakhir',TRUE);
        //     }
        //     else {
        //         return redirect(route('beranda'))->with(['status' => 'error','message' => ' Data Gagal Ditambah, Hubungi Administrator!.']);
        //     }
        // }

    public function pilih(Request $request)
    {
        $request->validate([
            // 'bemvote' => 'required',
            'pilihan' => 'required',
            'pemilihID' => 'required',
        ],
        [
            // 'bemvote.required' => 'ERROR, BEMVOTE TIDAK DAPAT DI COLLECT OLEH SISTEM!',
            'pilihan.required' => 'ERROR, PILIHAN ID TIDAK DAPAT DI COLLECT OLEH SISTEM!',
            'pemilihID.required' => 'ERROR, PEMILIH ID TIDAK DAPAT DI COLLECT OLEH SISTEM!',
        ]);
        if ($request->bemvote == null) {
            $finalvote = new Tervote;
            $finalvote->tim_id = '6';
            $finalvote->voting_dpm = $request->pilihan;
            $finalvote->voters_id = $request->pemilihID;
            $savevote = $finalvote->save();
    
            $hasvote = Voters::where('id', $request->pemilihID)->first();
            $votersudpate = $hasvote->update([
                'has_vote' => 1,
            ]);
    
            if($savevote && $votersudpate) {
                return redirect(route('aftervote'))->with('pageakhir',TRUE);
            }
            else {
                return redirect(route('beranda'))->with(['status' => 'error','message' => ' Data Gagal Ditambah, Hubungi Administrator!.']);
            }
        }
        else {
            return redirect(route('beranda'))->with(['status' => 'error','message' => ' Data Gagal Ditambah, Hubungi Administrator!.']);
        }

    }

    public function telahmemilih()
    {
        return view('tampilan.aftervote');
    }
}
