@extends('admin.layouts.app')

@section('title')
    Data Kandidat
@endsection

@section('breadcrumb')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Kandidat</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Voting</li>
                    <li class="breadcrumb-item active">Data Kandidat</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('admin_asset/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_asset/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">    
@endsection

@section('content')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Data Tim</h3>
    </div>
    <div class="card-body">
        @foreach ($tim as $tim_item)
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">{{ $tim_item->nama_tim }}</h3>
                    <div class="card-tools">
                        <a href="{{ url('administrator/kandidat/edittim/'. $tim_item->id) }}" class="btn btn-secondary btn-xs">Edit Tim</a>
                        <button type="button" class="btn btn-warning btn-xs" data-nama="{{ $tim_item->nama_tim }}" data-id="{{ $tim_item->id }}" data-toggle="modal" data-target="#modal_hapus_tim">Hapus Tim</button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="containter">
                        <div class="row text-center">
                            @foreach ($kandidat->where('tim_id', $tim_item->id) as $kand)
                                <div class="col-md-6 col-sm-12">
                                    {{ $kand->nama }}        
                                </div>
                            @endforeach
                        </div>
                        <div class="row text-center">
                            <div class="col">
                                {{ $tim_item->semboyan }}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {{-- <a href="#" class="btn btn-primary">Tambah Kandidat</a> --}}
                    <button type="button" data-id="{{ $tim_item->id }}" class="btn btn-primary" data-toggle="modal" data-target="#modal_tambah_kandidat">
                        Tambah Kandidat
                    </button>
                </div>
            </div>
        @endforeach
    </div>
    <div class="card-footer">
        <div class="form-group">
            {{-- <a href="#" class="btn btn-primary float-right">Tambah Tim</a> --}}
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_tambah_tim">
                Tambah Tim
            </button>
        </div>
    </div>
</div>


{{-- Modal Tambah Tim --}}
    <div class="modal fade" id="modal_tambah_tim">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Tim</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('/administrator/kandidat/addtim') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="NamaTim">Nama Tim</label>
                            <input type="text" class="form-control" name="nama_tim" id="NamaTim" placeholder="Masukan Nama Tim">
                        </div>
                        <div class="form-group">
                            <label for="SemboyanTim">Semboyan/Jargon</label>
                            <input type="text" class="form-control" name="semboyan_tim" id="SemboyanTim" placeholder="Masukan Semboyan Tim">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah Data</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

{{-- Modal Delete Tim --}}
    <div class="modal fade" id="modal_hapus_tim">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Hapus Tim</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda serius ingin menghapus tim ini?? ( <b>Seluruh data kandidat yg ada di tim ini akan ikut terhapus!</b> )</p>
                </div>
                <form action="{{ url('/administrator/kandidat/deltim') }}" method="post">
                    @csrf
                    <input type="hidden" id="tim_id" name="tim_id">
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Hapus Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


{{-- Modal Tambah Kandidat --}}
    <div class="modal fade" id="modal_tambah_kandidat">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Kandidat</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('administrator/kandidat/addkandidat') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="NamaKandidat">Nama Kandidat</label>
                            <input type="text" class="form-control" name="nama_kandidat" id="NamaKandidat" placeholder="Masukan Nama Kandidat">
                        </div>
                        <div class="form-group">
                            <label for="NimKandidat">NIM Kandidat</label>
                            <input type="text" class="form-control" name="nim_kandidat" id="NimKandidat" placeholder="Masukan NIM Kandidat">
                        </div>
                        <div class="form-group">
                            <label for="JurusanKandidat">Jurusan Kandidat</label>
                            <select id="JurusanKandidat" class="form-control select2bs4" style="width: 100%;" name="jurusan_kandidat">
                                <option selected="selected" value="Teknik Informatika">Teknik Informatika</option>
                                <option value="Teknik Sipil">Teknik Sipil</option>
                                <option value="Teknik Elektro">Teknik Elektro</option>
                                <option value="Teknik Mesin">Teknik Mesin</option>
                                <option value="Teknik Metalurgi">Teknik Metalurgi</option>
                                <option value="Teknik Industri">Teknik Industri</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="VisiKandidat">Visi Kandidat</label>
                            <textarea type="text" class="form-control" name="visi_kandidat" id="VisiKandidat" placeholder="Masukan Visi Kandidat"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="MisiKandidat">Misi Kandidat</label>
                            <textarea type="text" class="form-control" name="misi_kandidat" id="MisiKandidat" placeholder="Masukan Misi Kandidat"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="PengalamanKandidat">Pengalaman Kandidat</label>
                            <textarea type="text" class="form-control" name="pengalaman_kandidat" id="PengalamanKandidat" placeholder="Masukan Pengalaman Kandidat"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="GambarKandidat">Gambar Kandidat</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="GambarKandidat" name="image_kandidat">
                                    <label class="custom-file-label" id="GambarKandidatLabel" for="GambarKandidat">Pilih gambar</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">Upload</span>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="kandidat_tim_id" name="tim_id">
                        <input type="hidden" name="voting_id" value="1">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah Data</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@section('script')
<script src="{{ asset('admin_asset/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    document.getElementById("datavoting").classList.add("menu-open");
    document.getElementById("datavoting_kandidat").classList.add("active");

    $('.select2bs4').select2({
      theme: 'bootstrap4'
    });
    $('#GambarKandidat').change(function(e){
        if($('#GambarKandidat')[0].files){
            var numFiles = $('#GambarKandidat')[0].files
            var strings = numFiles[0].name;
            var res = strings.slice(0, 40)+" ...";
            document.getElementById('GambarKandidatLabel').innerText = res;
        }
    });

    // Modal Hapus Tim
        $('#modal_hapus_tim').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var nama = button.data('nama')
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-title').text('Hapus Tim - ' + nama);
            document.getElementById("tim_id").value = id;
        });


    // Modal Hapus Tim
        $('#modal_tambah_kandidat').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            document.getElementById("kandidat_tim_id").value = id;
        });
</script>

@endsection
