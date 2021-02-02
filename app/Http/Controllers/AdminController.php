<?php

namespace App\Http\Controllers;

use App\Tim;
use App\Voters;
use App\Voting;
use App\Kandidat;
use Illuminate\Http\Request;
use App\Helpers\CustomHelper;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => [
            'votingpageedit', 'votingpage_post',
            'kandidat_addtim', 'kandidat_deltim',
            'kandidat_edittim', 'kandidat_addkandidat',
            'kandidat_editkandidat', 'kandidat_delkandidat',
            'getQRCodeWa',

        ]]);
        $this->middleware('admin:Staff', ['only' => [
            'voter_revoke_verif', 'voter_unverif_post', 
            'voter_delete_unverif'
        ]]);
    }

    public function redirectindex()
    {
        return redirect('administrator');
    }

    public function getQRCodeWa()
    {
        return view('admin.qrcode');
    }

    public function index()
    {
        $mytime = Carbon::now();
        $votingstatusdb = Voting::where('id', 1)->first();
        $kandidatdb = Kandidat::all()->count();
        $verifvoters = Voters::where('verified', 1)->get()->count();
        $unverifvoters = Voters::where('verified', 0)->get()->count();
        $hasvotevoters = Voters::where('has_vote', 1)->get()->count();
        $votingstatusdb->pending = json_decode($votingstatusdb->pending, true);
        if ($votingstatusdb->mulai > $mytime) {
            $votingstatus = 'Belum Dimulai';
        }
        elseif ($votingstatusdb->berakhir < $mytime) {
            $votingstatus = 'Sudah Berakhir';
        }
        elseif($votingstatusdb->pending['status'] == 'false') {
            $votingstatus = 'Berjalan';
        }
        else {
            $votingstatus = 'Ditunda';
        }
        return view('admin.index', [
            'verifiedvoters' => $verifvoters, 'unverifvoters' => $unverifvoters, 'has_vote' => $hasvotevoters,
            'votingstat' => $votingstatus, 'kandidattotal' => $kandidatdb,
        ]);
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
        $tim_bem = Tim::where('pemilihan', 'BEM')->get();
        $tim_dpm = Tim::where('pemilihan', 'DPM')->first();
        $kandidat = Kandidat::all();
        return view('admin.kandidat', [
            'tim_bem' => $tim_bem,
            'tim_dpm' => $tim_dpm,
            'kandidat' => $kandidat
        ]);
        // dd($kandidat);
    }

    public function kandidat_addtim(Request $request)
    {
        $request->validate([
            'nama_tim' => 'required',
            'semboyan_tim' => 'required',
            'tipe_pemilihan' => 'required',
        ],
        [
            'nama_tim.required' => 'Nama Tim dibutuhkan!',
            'semboyan_tim.required' => 'Semboyan Tim dibutuhkan!',
            'tipe_pemilihan.required' => 'Pemilihan Tim dibutuhkan!',
            
        ]);
        $tim = new Tim;
        $tim->nama_tim = $request->nama_tim;
        $tim->semboyan = $request->semboyan_tim;
        $tim->pemilihan = $request->tipe_pemilihan;
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
            $orig = public_path('image/'.$kand->image);
            $resize = public_path('/image/kecil/'.$kand->image);
            if(File::exists($orig)){
                File::delete($orig);
                if (File::exists($resize)) {
                    File::delete($resize);
                }
                else {
                    return redirect()->route('adminKandidat')->with(['status' => 'error','message' => ' File yang ingin dihapus tidak ditemukan!']);
                }
            }
            else {
                return redirect()->route('adminKandidat')->with(['status' => 'error','message' => ' File yang ingin dihapus tidak ditemukan!']);
            }
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

    public function kandidat_edittim(Request $request)
    {
        $request->validate([
            'nama_tim' => 'required',
            'semboyan_tim' => 'required',
            'tim_id' => 'required',
        ],
        [
            'nama_tim.required' => 'Nama Tim dibutuhkan!',
            'semboyan_tim.required' => 'Semboyan Tim dibutuhkan!',
            'tim_id.required' => 'ID Tim dibutuhkan!',
            
        ]);
        // dd($request->all());
        $tim = Tim::where('id', $request->tim_id)->update([
            'nama_tim' => $request->nama_tim,
            'semboyan' => $request->semboyan_tim
        ]);
        if ($tim) {
            return redirect()->route('adminKandidat')->with(['status' => 'sukses', 'message' => ' Data Berhasil Diupdate!']);
        }
        else {
            return redirect()->route('adminKandidat')->with(['status' => 'error','message' => ' Data Gagal Dihapus! Check Database Connection.']);
        }
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
            'image_kandidat' => 'required|image|mimes:jpeg,png,jpg|max:2048',
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
            'image_kandidat.max' => 'Gambar Kandidat maximal size 2048Mb!',
            
        ]);
        $count_pengalaman  = substr_count($request->pengalaman_kandidat,"\r\n");
        $count_visi  = substr_count($request->visi_kandidat,"\r\n");
        $count_misi  = substr_count($request->misi_kandidat,"\r\n");
        $data_pengalaman = ($count_pengalaman != 0) ? CustomHelper::ExplodeStringSpacing($request->pengalaman_kandidat, true) : $data_pengalaman = $request->pengalaman_kandidat;
        $data_visi = ($count_visi != 0) ? CustomHelper::ExplodeStringSpacing($request->visi_kandidat, true) : $data_visi = $request->visi_kandidat;
        $data_misi = ($count_misi != 0) ? CustomHelper::ExplodeStringSpacing($request->misi_kandidat, true) : $data_misi = $request->misi_kandidat;
        // dd($request->pengalaman_kandidat);
        // dd($data_visi);
        if($file = $request->file('image_kandidat')) {
            $name = Carbon::now()->timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/image');
            $canvas = Image::canvas(102, 102);
            $resizeImage  = Image::make($file)->resize(102, 102, function($constraint) {
                $constraint->aspectRatio();
            })->trim();
            $canvas->insert($resizeImage, 'center');
            $canvas->save($destinationPath . '/kecil'. '/' . $name);
            if($file->move($destinationPath, $name)) {
                $kandidat = new Kandidat;
                $kandidat->nama = $request->nama_kandidat;
                $kandidat->nim = $request->nim_kandidat;
                $kandidat->jurusan = $request->jurusan_kandidat;
                $kandidat->visi = $data_visi;
                $kandidat->misi = $data_misi;
                $kandidat->pengalaman = $data_pengalaman;
                $kandidat->image = $name;
                $kandidat->voting_id = $request->voting_id;
                $kandidat->tim_id = $request->tim_id;
                $kandidat_db = $kandidat->save();
                if ($kandidat_db) {
                    return redirect()->route('adminKandidat')->with(['status' => 'sukses', 'message' => ' Data Berhasil Ditambahkan!']);
                }
                else {
                    return redirect()->route('adminKandidat')->with(['status' => 'error','message' => ' Data Gagal Ditambah! Check Database Connection.']);
                }

                return redirect()->route('adminKandidat')->with(['status' => 'sukses', 'message' => ' Data Berhasil Ditambah!']);
            }
            else {
                return redirect()->route('adminKandidat')->with(['status' => 'error','message' => ' Data Gagal Ditambah! Check File Permission.']);
            }
        }
        else {
            return redirect()->route('adminKandidat')->with(['status' => 'error','message' => ' Data Gagal Ditambah! Check Format Gambar yg dikirim.']);
        }
    }

    public function kandidat_editkandidat(Request $request)
    {
        $request->validate([
            'nama_kandidat' => 'required',
            'nim_kandidat' => 'required',
            'jurusan_kandidat' => 'required',
            'visi_kandidat' => 'required',
            'misi_kandidat' => 'required',
            'pengalaman_kandidat' => 'required',
            'tim_id' => 'required',
            'kandidat_id' => 'required',
            'voting_id' => 'required',
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
            'kandidat_id.required' => 'Kandidat ID dibutuhkan!',
            
        ]);
        $kandidat = Kandidat::where('id', $request->kandidat_id)->first();
        $count_pengalaman  = substr_count($request->pengalaman_kandidat,"\r\n");
        $count_visi  = substr_count($request->visi_kandidat,"\r\n");
        $count_misi  = substr_count($request->misi_kandidat,"\r\n");
        $data_pengalaman = ($count_pengalaman != 0) ? CustomHelper::ExplodeStringSpacing($request->pengalaman_kandidat, true) : $data_pengalaman = $request->pengalaman_kandidat;
        $data_visi = ($count_visi != 0) ? CustomHelper::ExplodeStringSpacing($request->visi_kandidat, true) : $data_visi = $request->visi_kandidat;
        $data_misi = ($count_misi != 0) ? CustomHelper::ExplodeStringSpacing($request->misi_kandidat, true) : $data_misi = $request->misi_kandidat;
        if ($request->edit_image == "on") {
            $request->validate([
                'image_kandidat' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ],
            [
                'image_kandidat.required' => 'Gambar Kandidat dibutuhkan!',
                'image_kandidat.max' => 'Gambar Kandidat maximal size 2048Mb!',
                
            ]);
            $orig = public_path('image/'.$kandidat->image);
            $resize = public_path('/image/kecil/'.$kandidat->image);
            if(File::exists($orig)){
                File::delete($orig);
                if (File::exists($resize)) {
                    File::delete($resize);
                }
                else {
                    return redirect()->route('adminKandidat')->with(['status' => 'error','message' => ' File yang ingin dihapus tidak ditemukan!']);
                }
            }
            else {
                return redirect()->route('adminKandidat')->with(['status' => 'error','message' => ' File yang ingin dihapus tidak ditemukan!']);
            }
            if($file = $request->file('image_kandidat')) {
                $name = Carbon::now()->timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/image');
                $canvas = Image::canvas(102, 102);
                $resizeImage  = Image::make($file)->resize(102, 102, function($constraint) {
                    $constraint->aspectRatio();
                })->trim();
                $canvas->insert($resizeImage, 'center');
                $canvas->save($destinationPath . '/kecil'. '/' . $name);
                if(! $file->move($destinationPath, $name)) {
                    return redirect()->route('adminKandidat')->with(['status' => 'error','message' => ' Data Gagal Ditambah! Check File Permission.']);
                }
            }
            else {
                return redirect()->route('adminKandidat')->with(['status' => 'error','message' => ' Data Gagal Ditambah! Check Format Gambar yg dikirim.']);
            }
            
            $kandidat = Kandidat::where('id', $request->kandidat_id)->update([
                'nama' => $request->nama_kandidat,
                'nim' => $request->nim_kandidat,
                'jurusan' => $request->jurusan_kandidat,
                'visi' => $data_visi,
                'misi' => $data_misi,
                'pengalaman' => $data_pengalaman,
                'image' => $name,
            ]);
            if ($kandidat) {
                return redirect()->route('adminKandidat')->with(['status' => 'sukses', 'message' => ' Data Berhasil Diupdate!']);
            }
            else {
                return redirect()->route('adminKandidat')->with(['status' => 'error','message' => ' Data Gagal Dihapus! Check Database Connection.']);
            }
        }
        else {
            $kandidat = Kandidat::where('id', $request->kandidat_id)->update([
                'nama' => $request->nama_kandidat,
                'nim' => $request->nim_kandidat,
                'jurusan' => $request->jurusan_kandidat,
                'visi' => $data_visi,
                'misi' => $data_misi,
                'pengalaman' => $data_pengalaman,
            ]);
            if ($kandidat) {
                return redirect()->route('adminKandidat')->with(['status' => 'sukses', 'message' => ' Data Berhasil Diupdate!']);
            }
            else {
                return redirect()->route('adminKandidat')->with(['status' => 'error','message' => ' Data Gagal Dihapus! Check Database Connection.']);
            }
        }
    }

    public function kandidat_delkandidat(Request $request)
    {
        $request->validate([
            'kand_id' => 'required',
        ],
        [
            'kand_id.required' => 'ID Kandidat dibutuhkan!',
            
        ]);
        
        $kandidat = Kandidat::where('id', $request->kand_id)->first();
        $orig = public_path('image/'.$kandidat->image);
        $resize = public_path('/image/kecil/'.$kandidat->image);
        if(File::exists($orig)){
            File::delete($orig);
            if (File::exists($resize)) {
                File::delete($resize);
            }
            else {
                return redirect()->route('adminKandidat')->with(['status' => 'error','message' => ' File yang ingin dihapus tidak ditemukan!']);
            }
        }
        else {
            return redirect()->route('adminKandidat')->with(['status' => 'error','message' => ' File yang ingin dihapus tidak ditemukan!']);
        }
        $hapus = Kandidat::destroy($request->kand_id);
        if ($hapus) {
            return redirect()->route('adminKandidat')->with(['status' => 'sukses', 'message' => ' Data Berhasil Dihapus!']);
        }
        else {
            return redirect()->route('adminKandidat')->with(['status' => 'error','message' => ' Data Gagal Dihapus! Check Database Connection.']);
        }
    }
    
    public function voter_verif()
    {
        $voter = Voters::where('verified', 1)->simplePaginate(15);
        return view('admin.voters_ver', ['verif' => $voter]);
    }

    public function voter_revoke_verif(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'voters_id' => 'required',
        ],
        [
            'voters_id.required' => 'ID Voters dibutuhkan!',
            
        ]);
        $voting = Voters::where('id', $request->voters_id)->update([
            'verified' => 0,
        ]);
        if ($voting) {
            return redirect()->route('adminVotersVer')->with(['status' => 'sukses', 'message' => ' Data Berhasil Diupdate!']);
        }
        else {
            return redirect()->route('adminVotersVer')->with(['status' => 'error','message' => ' Data Gagal Diupdate! Check Database Connection.']);
        }

    }

    public function voter_unverif()
    {
        $voter = Voters::where('verified', 0)->simplePaginate(15);
        return view('admin.voters_unv', ['unverif' => $voter]);
    }

    public function voter_unverif_post(Request $request)
    {
        $request->validate([
            'voters_id' => 'required',
        ],
        [
            'voters_id.required' => 'ID Voters dibutuhkan!',
            
        ]);
        $voting = Voters::where('id', $request->voters_id)->first();
        $client = new Client();
        $url = "http://api.evoting.ft.uts.ac.id:1380/send-message";
        $method = 'POST';
        $data['tokenapi'] = '$2y$10$DW9iRCyU1Urj5nOI6Dp4he8lISFk2cItJgCIrnkbzCxmZeo8Ca4ya';
        $data['number'] = $voting->nmor_wa;
        $data['nama'] = $voting->nama;
        $data['token'] = $voting->token;
        try {
            $client->request($method, $url, [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => $data
            ]);

        } catch (ConnectException $ec) {
            return redirect()->route('adminVotersunVer')->with(['status' => 'error','message' => ' Data Gagal Diupdate! Gagal Berkomunikasi dengan API.']);
        } catch (RequestException $eq) {
            return redirect()->route('adminVotersunVer')->with(['status' => 'error','message' => ' Data Gagal Diupdate! Check API Connection.']);
        }

        $resultakhir = $voting->update([
            'verified' => 1,
        ]);
        if ($resultakhir) {
            return redirect()->route('adminVotersunVer')->with(['status' => 'sukses', 'message' => ' Data Berhasil Diupdate!']);
        }
        else {
            return redirect()->route('adminVotersunVer')->with(['status' => 'error','message' => ' Data Gagal Diupdate! Check Database Connection.']);
        }
    }

    public function voter_delete_unverif(Request $request)
    {
        $request->validate([
            'voters_id' => 'required',
        ],
        [
            'voters_id.required' => 'ID Voters dibutuhkan!',
            
        ]);
        $voting = Voters::destroy($request->voters_id);
        if ($voting) {
            return redirect()->route('adminVotersunVer')->with(['status' => 'sukses', 'message' => ' Data Berhasil Dihapus!']);
        }
        else {
            return redirect()->route('adminVotersunVer')->with(['status' => 'error','message' => ' Data Gagal Dihapus! Check Database Connection.']);
        }
    }
}
