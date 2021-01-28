@extends('tampilan.layouts.app2')

@section('title')
    E-Voting Beranda
@endsection

@section('body')
    {{-- <a class="dropdown-item" href="{{ route('logoutvoters') }}"
    onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
    {{ __('Logout') }}
    </a>

    <form id="logout-form" action="{{ route('logoutvoters') }}" method="POST" class="d-none">
    @csrf
    </form> --}}

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
                            <div class="info">
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
                                    <div class="row">
                                        <div class="col col-sm-12">
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" 
                                            data-target="#modal_details" data-nama="{{ $kand->nama }}" data-nim="{{ $kand->nim }}" data-jurusan="{{ $kand->jurusan }}" 
                                            data-visi="{{ $kand->visi }}" data-misi="{{ $kand->misi }}" data-pengalaman="{{ $kand->pengalaman }}" 
                                            data-image="{{ asset('image/'.$kand->image) }}" >
                                                Detail
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </main>
                </div>
            </div>
        @endforeach
    </main>

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
                <p id="nama_kandidat"></p>
                <p id="nim_kandidat"></p>
                <p id="jurusan_kandidat"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
            var nim = button.data('nim')
            var jurusan = button.data('jurusan')
            var visi = button.data('visi')
            var misi = button.data('misi')
            var pengalaman = button.data('pengalaman')
            var image = button.data('image')
            var modal = $(this)
            modal.find('.modal-title').text(nama);
            document.getElementById("image_kandidat").src = image;
            document.getElementById("nama_kandidat").innerHTML = nama;
            document.getElementById("nim_kandidat").innerHTML = nim;
            document.getElementById("jurusan_kandidat").innerHTML = jurusan;
            console.log(visi);
            console.log(misi);
            console.log(pengalaman);
        });
    </script>
@endsection