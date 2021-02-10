@extends('tampilan.layouts.app2')

@section('title')
    E-Voting Beranda
@endsection

@section('body')

    @if (isset($dpm))
        @foreach ($tim_dpm as $dpm)
            @if (count($kandidat->where('tim_id', $dpm->id)->where('jurusan', auth()->guard('voter')->user()->prodi)) != 0)
                <h1 class="h1-awal">Pemilihan DPM Fakultas Teknik Jurusan {{ auth()->guard('voter')->user()->prodi }}</h1>
                <main id="tim_bem">
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
                                <button type="button" class="btn btn-primary btn-danger" data-voteid="{{ auth()->guard('voter')->user()->id }}" data-id="{{ $kand->id }}" data-toggle="modal" data-target="#ModalPilih">COBLOS</button>
                            </div>
                        </div>
                    @endforeach
                </main>
                <script>
                    var calon = 1;
                </script>
            @else
                <h1 class="h1-awal">Pemilihan DPM Fakultas Teknik Jurusan {{ auth()->guard('voter')->user()->prodi }}</h1>
                <main id="tim_bem">
                    <div class="card">
                        <div class="card-body">
                            <div class="bem_bagian">
                                <div class="info infoconte">
                                    <blockquote class="blockquote text-center">
                                        Jurusan ini tak memiliki kandidat calon!
                                        <footer class="blockquote-footer">Jurusan ini sedang tak baik - baik saja</footer>
                                        <br><br>
                                        <small>Halaman ini akan terredirect setelah 7 detik ...</small>
                                </blockquote>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <script>
                    var calon = 0;
                </script>
            @endif
                    
        @endforeach


        {{-- Modal Pilih  --}}
            <form action="{{ url('/beranda/pilih') }}" method="post">
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

    @if (isset($dpm))
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



            if (calon == 1) {
                $('#ModalPilih').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget)
                    var id = button.data('id')
                    var voteid = button.data('voteid')
                    document.getElementById('pilihanID').value = id;
                    document.getElementById('pemilihID').value = voteid;
                });
            }
            else {
                var base_path = "{{url('/')}}";
                setTimeout(function(){
                    window.location.href = base_path + '/beranda/telahmemilih';
                }, 7000);
            }
        </script>
    @else
        <script>
            var base_path = "{{url('/')}}";
            setTimeout(function(){
                window.location.href = base_path + '/beranda';
            }, 5000);
        </script>
    @endif

@endsection