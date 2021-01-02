<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Voting;
use App\Helpers\CustomHelper;
use App\Kandidat;
use App\Tim;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => ['votingpageedit','votingpage_post']]);
    }

    public function redirectindex()
    {
        return redirect('administrator');
    }

    public function index()
    {
        return view('admin.index');
    }

    public function votingpage()
    {
        $voting = Voting::where('id', 1)->first();
        $tglmulai = CustomHelper::DateNormalize($voting->mulai);
        $tglakhir = CustomHelper::DateNormalize($voting->berakhir);
        $tglperiode = $tglmulai . ' - ' . $tglakhir;
        $pending = ($voting->result == 'pending') ? '' : 'checked';
        $stat_pending = $voting->pending;
        $stat_pending = json_decode($stat_pending, true);
        $stat_pending = ($stat_pending['status']) ? $stat_pending['ket'] : '';
        // $stat_pending = $stat_pending['ket'];
        return view('admin.voting', [
            'voting' => $voting,
            'tglmulai' => $tglmulai,
            'tglperiode' => $tglperiode,
            'pending' => $pending,
            'stat_pending' =>$stat_pending
        ]);
    }

    public function votingpageedit()
    {
        $voting = Voting::where('id', 1)->first();
        $tglmulai = CustomHelper::DateNormalize($voting->mulai);
        $tglakhir = CustomHelper::DateNormalize($voting->berakhir);
        $tglperiode = $tglmulai . ' - ' . $tglakhir;
        $pending = ($voting->result == 'pending') ? '' : 'checked';
        $stat_pending = $voting->pending;
        $stat_pending = json_decode($stat_pending, true);
        $stat_pending = ($stat_pending['status']) ? $stat_pending['ket'] : '';
        // $stat_pending = $stat_pending['ket'];
        return view('admin.edit.voting', [
            'voting' => $voting,
            'tglmulai' => $tglmulai,
            'tglperiode' => $tglperiode,
            'pending' => $pending,
            'stat_pending' =>$stat_pending
        ]);
    }

    public function votingpage_post(Request $request)
    {
        $request->validate([
            'nama_voting' => 'required',
            'tglmulai_voting' => 'required',
            'periode_voting'=> 'required'
        ],
        [
            'nama_voting.required' => 'Nama Voting dibutuhkan!',
            'tglmulai_voting.required' => 'Tanggal Mulai Voting dibutuhkan!',
            'periode_voting.required' => 'Periode Voting dibutuhkan!',
            
        ]);
        $berakhir = substr($request->periode_voting, strpos($request->periode_voting, " - "));
        $berakhir = substr($berakhir, 3);
        $berakhir = CustomHelper::DateNormalize($berakhir, true);
        $mulai = CustomHelper::DateNormalize($request->tglmulai_voting, true);
        if($request->voting_status_check) {
            $pending = [
                'status' => 'false',
                'ket' => ""
            ];
            $result = 'berjalan';
        }
        else {
            $pending = [
                'status' => 'true',
                'ket' => $request->pending_ket_voting
            ];
            $result = 'pending';
        }
        $pending = json_encode($pending, JSON_UNESCAPED_SLASHES);

        $voting = Voting::where('id', 1)->update([
            'judul' => $request->nama_voting,
            'mulai' => $mulai,
            'berakhir' => $berakhir,
            'pending' => $pending,
            'result' => $result
        ]);
        if($voting) {
            return redirect()->route('adminDashboard')->with(['status' => 'sukses','message' => ' Data Berhasil Dirubah!']);
        }
        else {
            return redirect()->route('adminDashboard')->with(['status' => 'error','message' => ' Data Gagal Dirubah! Check Database Connection.']);
        }
    }

    public function kandidat_index()
    {
        $tim = Tim::all();
        $kandidat = Kandidat::all();
        return view('admin.kandidat', [
            'tim' => $tim,
            'kandidat' => $kandidat
        ]);
        // dd($kandidat);
    }

    public function kandidat_addtim(Request $request)
    {
        $request->validate([
            'nama_tim' => 'required',
            'semboyan_tim' => 'required',
        ],
        [
            'nama_tim.required' => 'Nama Tim dibutuhkan!',
            'semboyan_tim.required' => 'Semboyan Tim dibutuhkan!',
            
        ]);
        $tim = new Tim;
        $tim->nama_tim = $request->nama_tim;
        $tim->semboyan = $request->semboyan_tim;
        $savetim = $tim->save();
        if ($savetim) {
            return redirect()->route('adminKandidat')->with(['status' => 'sukses', 'message' => ' Data Berhasil Ditambahkan!']);
        }
        else {
            return redirect()->route('adminKandidat')->with(['status' => 'error','message' => ' Data Gagal Ditambah! Check Database Connection.']);
        }
    }

    public function kandidat_deltim(Request $request)
    {
        $tim = Tim::where('id', $request->tim_id)->first();
        $kandidat = Kandidat::where('tim_id', $request->tim_id)->get();
        foreach ($kandidat as $kand) {
            $del_kandid = Kandidat::destroy($kand->id);
            if ($del_kandid) {
                continue;
            }
            else {
                return redirect()->route('adminKandidat')->with(['status' => 'error','message' => ' Data Gagal Dihapus! Hubungi Admin.']);
            }
        };
        $del_tim = Tim::destroy($tim->id);
        if ($del_tim) {
            return redirect()->route('adminKandidat')->with(['status' => 'sukses', 'message' => ' Data Berhasil Dihapus!']);
        }
        else {
            return redirect()->route('adminKandidat')->with(['status' => 'error','message' => ' Data Gagal Dihapus! Check Database Connection.']);
        }
    }

    public function kandidat_edittim($id)
    {
        $tim = Tim::where('id', $id)->first();
        $kandidat = Kandidat::where('tim_id', $id)->get();
        return view('admin.edit.kandidat',[
            'tim' => $tim,
            'kandidat' => $kandidat
        ]);
    }

    public function kandidat_addkandidat(Request $request)
    {
        $request->validate([
            'nama_kandidat' => 'required',
            'nim_kandidat' => 'required',
            'jurusan_kandidat' => 'required',
            'visi_kandidat' => 'required',
            'misi_kandidat' => 'required',
            'pengalaman_kandidat' => 'required',
            'tim_id' => 'required',
            'voting_id' => 'required',
            'image_kandidat' => 'required',
        ],
        [
            'nama_kandidat.required' => 'Nama Kandidat dibutuhkan!',
            'nim_kandidat.required' => 'NIM Kandidat dibutuhkan!',
            'jurusan_kandidat.required' => 'Jurusan Kandidat dibutuhkan!',
            'visi_kandidat.required' => 'Visi Kandidat dibutuhkan!',
            'misi_kandidat.required' => 'Misi Kandidat dibutuhkan!',
            'pengalaman_kandidat.required' => 'Pengalaman Kandidat dibutuhkan!',
            'tim_id.required' => 'Tim ID dibutuhkan!',
            'voting_id.required' => 'Voting ID dibutuhkan!',
            'image_kandidat.required' => 'Gambar Kandidat dibutuhkan!',
            
        ]);
        dd($request->all());
    }
    
    public function kandidat_edittim_post(Request $request)
    {
        dd($request->all());
    }
}
