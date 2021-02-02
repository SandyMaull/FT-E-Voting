@extends('tampilan.layouts.app2')

@section('title')
    E-Voting Beranda
@endsection

@section('body')

    @if (isset($bem) && Session::get('dpm') != TRUE)
        <h1 class="h1-awal">Pemilihan BEM Fakultas Teknik</h1>
        <main id="tim_bem">
            @foreach ($tim_bem as $bem)
                <div class="card">
                    <div class="card-header">
                        <blockquote class="blockquote text-center">
                            <p class="mb-0">{{ $bem->nama_tim }}</p>
                            <footer class="blockquote-footer">{{ $bem->semboyan }}</footer>
                        </blockquote>
                    </div>
                    <div class="card-body">
                        <main id="bem_bagian">
                            @foreach ($kandidat->where('tim_id', $bem->id) as $kand)
                                <div class="info infoconte">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col col-sm-12">
                                                <img id="KandidatImage" src="{{ asset('image/kecil/'. $kand->image) }}"  alt="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col col-sm-12">   
                                                <ul class="list-unstyled">
                                                    <li><strong>{{ $kand->nama }}</strong></li>
                                                    <li><small>{{ $kand->nim }}</small></li>
                                                    <li><em>{{ $kand->jurusan }}</em></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container buttondetails">
                                        <div class="row">
                                            <div class="col">
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" 
                                                data-target="#modal_details" data-namatim="{{ $bem->nama_tim }}" data-nama="{{ $kand->nama }}" data-nim="{{ $kand->nim }}" data-jurusan="{{ $kand->jurusan }}" 
                                                data-visi="{{ $kand->visi }}" data-misi="{{ $kand->misi }}" data-pengalaman="{{ $kand->pengalaman }}" 
                                                data-image="{{ asset('image/'.$kand->image) }}">
                                                    Detail
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </main>
                        <button type="button" class="btn btn-primary btn-danger" data-voteid="{{ auth()->guard('voter')->user()->id }}" data-id="{{ $bem->id }}" data-toggle="modal" data-target="#ModalPilih">COBLOS</button>
                    </div>
                </div>
            @endforeach
        </main>

        {{-- Modal Pilih  --}}
            <form action="{{ url('/beranda/pilihbem') }}" method="post">
                @csrf
                <div class="modal fade" id="ModalPilih" tabindex="-1" role="dialog" aria-labelledby="ModalPilihLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ModalPilihLabel">Perhatian!</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <strong>Apakah Anda Sudah Yakin dengan Pilihan Anda?</strong>
                                <p><small>data yang sudah diinput tidak bisa diubah kembali, pastikan anda memilih dengan benar!</small></p>
                                <input type="hidden" id="pilihanID" name="pilihan">
                                <input type="hidden" id="pemilihID" name="pemilihID">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Ya, Lanjutkan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
    @elseif (Session::get('dpm'))
        <h1 class="h1-awal">Pemilihan DPM Fakultas Teknik Jurusan {{ auth()->guard('voter')->user()->prodi }}</h1>
        <main id="tim_bem">
            @foreach ($tim_dpm as $dpm)
                @foreach ($kandidat->where('tim_id', $dpm->id)->where('jurusan', auth()->guard('voter')->user()->prodi) as $kand)
                    <div class="card">
                        <div class="card-header">
                            <blockquote class="blockquote text-center">
                                <p class="mb-0">{{ $kand->nama }}</p>
                                <footer class="blockquote-footer">{{ $kand->nim }}</footer>
                            </blockquote>
                        </div>
                            <div class="card-body">
                                <main id="bem_bagian">
                                    <div class="info infoconte">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col col-sm-12">
                                                    <img id="KandidatImage" src="{{ asset('image/kecil/'. $kand->image) }}"  alt="">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col col-sm-12">   
                                                    <ul class="list-unstyled">
                                                        <li><strong>{{ $kand->nama }}</strong></li>
                                                        <li><small>{{ $kand->nim }}</small></li>
                                                        <li><em>{{ $kand->jurusan }}</em></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </main>
                                <button type="button" class="btn btn-primary" data-toggle="modal" 
                                    data-target="#modal_details" data-namatim="{{ $kand->nama }}" data-nama="{{ $kand->nama }}" data-nim="{{ $kand->nim }}" data-jurusan="{{ $kand->jurusan }}" 
                                    data-visi="{{ $kand->visi }}" data-misi="{{ $kand->misi }}" data-pengalaman="{{ $kand->pengalaman }}" 
                                    data-image="{{ asset('image/'.$kand->image) }}">
                                        Detail
                                </button>
                            <button type="button" class="btn btn-primary btn-danger" data-voteid="{{ auth()->guard('voter')->user()->id }}" data-id="{{ $dpm->id }}" data-toggle="modal" data-target="#ModalPilih">COBLOS</button>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </main>

        {{-- Modal Pilih  --}}
            <form action="{{ url('/beranda/pilihdpm') }}" method="post">
                @csrf
                <div class="modal fade" id="ModalPilih" tabindex="-1" role="dialog" aria-labelledby="ModalPilihLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ModalPilihLabel">Perhatian!</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <strong>Apakah Anda Sudah Yakin dengan Pilihan Anda?</strong>
                                <p><small>data yang sudah diinput tidak bisa diubah kembali, pastikan anda memilih dengan benar!</small></p>
                                <input type="hidden" id="bemvote" name="bemvote" value="{{ Session::get('bemvote') }}">
                                <input type="hidden" id="pilihanID" name="pilihan">
                                <input type="hidden" id="pemilihID" name="pemilihID">
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Ya, Lanjutkan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
    @else
        BERANDA        
    @endif


    {{-- Modals Details --}}
        <div class="modal fade" id="modal_details" tabindex="-1" role="dialog" aria-labelledby="ModalDetailsTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalDetailsTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="image_kandidat" alt="Foto Kandidat" width="300px">
                    <div class="container">
                        <div class="row mt-3 bg-info text-white">
                            <div class="col-6">
                                <span>Nama:</span>
                            </div>
                            <div class="col-6">
                                <span id="nama_kandidat"></span>
                            </div>
                        </div>
                        <div class="row bg-light text-dark">
                            <div class="col-6">
                                <span>NIM:</span>
                            </div>
                            <div class="col-6">
                                <span id="nim_kandidat"></span>
                            </div>
                        </div>
                        <div class="row bg-info text-white">
                            <div class="col-6">
                                <span>Jurusan:</span>
                            </div>
                            <div class="col-6">
                                <span id="jurusan_kandidat"></span>
                            </div>
                        </div>
                        <div class="row bg-light text-dark">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <span>Visi:</span>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12" id="visiList"></div>
                        </div>
                        <div class="row bg-info text-white">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <span>Misi:</span>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12" id="misiList"></div>
                        </div>
                        <div class="row bg-light text-dark">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <span>Pengalaman:</span>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12" id="pengalamanList"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
                </div>
            </div>
        </div>



@endsection

@section('script')
    <script>
        $('#modal_details').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var nama = button.data('nama')
            var namatim = button.data('namatim')
            var nim = button.data('nim')
            var jurusan = button.data('jurusan')
            var visi = checkifObject(button.data('visi'))
            var misi = checkifObject(button.data('misi'))
            var pengalaman = checkifObject(button.data('pengalaman'))
            var image = button.data('image')


            var visiList = document.getElementById("visiList");
            var misiList = document.getElementById("misiList");
            var pengalamanList = document.getElementById("pengalamanList");
            visiList.innerHTML = "";
            misiList.innerHTML = "";
            pengalamanList.innerHTML = "";
            visiList.appendChild(makeUL(visi));
            misiList.appendChild(makeUL(misi));
            pengalamanList.appendChild(makeUL(pengalaman));

            function checkifObject(data) {
                if (typeof data === 'object' && data !== null) {
                    var data = Object.keys(data).map((key) => [data[key].slice(2)]);
                }
                return data;
            };
            function makeUL(array) {
                var list = document.createElement('ol');
                if (array instanceof Array && array !== null) {
                    for (var i = 0; i < array.length; i++) {
                        var item = document.createElement('li');
                        item.appendChild(document.createTextNode(array[i]));
                        list.appendChild(item);
                    }
                }
                else {
                    var item = document.createElement('li');
                    item.appendChild(document.createTextNode(array));
                    list.appendChild(item);
                    list.style.listStyleType = "none";
                    list.style.paddingLeft = "0";
                }
                return list;
            }


            var modal = $(this)
            modal.find('.modal-title').text(namatim);
            document.getElementById("image_kandidat").src = image;
            document.getElementById("nama_kandidat").innerHTML = nama;
            document.getElementById("nim_kandidat").innerHTML = nim;
            document.getElementById("jurusan_kandidat").innerHTML = jurusan;
        });
    </script>
    @if (isset($bem) && Session::get('dpm') != TRUE)
        <script>
            $('#ModalPilih').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var id = button.data('id')
                var voteid = button.data('voteid')
                document.getElementById('pilihanID').value = id;
                document.getElementById('pemilihID').value = voteid;
            });
        </script>
    @elseif (Session::get('dpm'))
        <script>
            $('#ModalPilih').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var id = button.data('id')
                var voteid = button.data('voteid')
                document.getElementById('pilihanID').value = id;
                document.getElementById('pemilihID').value = voteid;
            });
        </script>
    @else
        <script>
            setTimeout(function(){
                window.location.href = 'https://evoting.ft.uts.ac.id/beranda';
            }, 5000);
        </script>
    @endif

@endsection