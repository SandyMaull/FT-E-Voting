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
                        <button type="submit" class="btn btn-secondary btn-xs" data-semboyan="{{ $tim_item->semboyan }}" data-nama="{{ $tim_item->nama_tim }}" data-id="{{ $tim_item->id }}" data-toggle="modal" data-target="#modal_edit_tim">Edit Tim</button>
                        <button type="button" class="btn btn-warning btn-xs" data-nama="{{ $tim_item->nama_tim }}" data-id="{{ $tim_item->id }}" data-toggle="modal" data-target="#modal_hapus_tim">Hapus Tim</button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="containter">
                        <div class="row text-center">
                            @foreach ($kandidat->where('tim_id', $tim_item->id) as $kand)
                                <div class="col-md-6 col-sm-12">
                                    <div class="card bg-light">
                                        <div class="card-header text-muted border-bottom-0">
                                            Kandidat - {{ $loop->iteration }}
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="row">
                                                <div class="col-mb-5 col-sm-12 text-center">
                                                    <img src="{{ asset('image/kecil/' . $kand->image) }}" alt="" class="img-circle img-fluid">
                                                </div>
                                                <div class="col-mb-7 col-sm-12">
                                                    <h2 class="lead"><b>{{ $kand->nama }}</b></h2>
                                                    <p class="text-muted text-sm"><b>Jurusan: </b> {{ $kand->jurusan }} </p>
                                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                                    <li class="small"><span class="fa-li"><i class="fas fa-id-badge"></i></span> NIM: {{ $kand->nim }}</li>
                                                    <li class="small"><span class="fa-li"><i class="fas fa-eye"></i></span> Visi: {{ $kand->visi }}</li>
                                                    <li class="small"><span class="fa-li"><i class="fas fa-list"></i></span> Misi: {{ $kand->misi }}</li>
                                                    <li class="small"><span class="fa-li"><i class="fas fa-briefcase"></i></span> Pengalaman: {{ $kand->pengalaman }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="text-right">
                                            <button type="submit" data-id="{{ $kand->id }}" class="btn btn-sm bg-teal" data-toggle="modal" data-target="#modal_hapus_kandidat">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal_edit_kandidat"
                                            data-nama="{{ $kand->nama }}" data-nim="{{ $kand->nim }}" data-jurusan="{{ $kand->jurusan }}" data-visi="{{ $kand->visi }}" data-id="{{ $kand->id }}"
                                            data-misi="{{ $kand->misi }}" data-pengalaman="{{ $kand->pengalaman }}" data-image="{{ $kand->image }}" data-voting="{{ $kand->voting_id }}"
                                            data-tim="{{ $kand->tim_id }}">
                                                <i class="fas fa-user-edit"></i>
                                            </button>
                                            </div>
                                        </div>
                                    </div>        
                                </div>
                            @endforeach
                        </div>
                        <div class="row text-center">
                            <div class="col">
                                <samp>{{ $tim_item->semboyan }}</samp>
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


{{-- Modal Edit Tim --}}
    <div class="modal fade" id="modal_edit_tim">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('/administrator/kandidat/edittim') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="NamaTimEdit">Nama Tim</label>
                            <input type="text" class="form-control" name="nama_tim" id="NamaTimEdit" placeholder="Masukan Nama Tim">
                        </div>
                        <div class="form-group">
                            <label for="SemboyanTimEdit">Semboyan/Jargon</label>
                            <input type="text" class="form-control" name="semboyan_tim" id="SemboyanTimEdit" placeholder="Masukan Semboyan Tim">
                        </div>
                    </div>
                    <input type="hidden" id="tim_id_edit" name="tim_id">
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-secondary">Edit Data</button>
                    </div>
                </form>
            </div>
        </div>
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
                            <small>Extensi gambar diharuskan JPG,JPEG,PNG dan maximal size 2MB</small>
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


{{-- Modal Edit Kandidat --}}
    <div class="modal fade" id="modal_edit_kandidat">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Kandidat</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('administrator/kandidat/editkandidat') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="NamaKandidatEdit">Nama Kandidat</label>
                            <input type="text" class="form-control" name="nama_kandidat" id="NamaKandidatEdit" placeholder="Masukan Nama Kandidat">
                        </div>
                        <div class="form-group">
                            <label for="NimKandidatEdit">NIM Kandidat</label>
                            <input type="text" class="form-control" name="nim_kandidat" id="NimKandidatEdit" placeholder="Masukan NIM Kandidat">
                        </div>
                        <div class="form-group">
                            <label for="JurusanKandidatEdit">Jurusan Kandidat</label>
                            <select id="JurusanKandidatEdit" class="form-control select2bs4" style="width: 100%;" name="jurusan_kandidat">
                                <option selected="selected" value="Teknik Informatika">Teknik Informatika</option>
                                <option value="Teknik Sipil">Teknik Sipil</option>
                                <option value="Teknik Elektro">Teknik Elektro</option>
                                <option value="Teknik Mesin">Teknik Mesin</option>
                                <option value="Teknik Metalurgi">Teknik Metalurgi</option>
                                <option value="Teknik Industri">Teknik Industri</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="VisiKandidatEdit">Visi Kandidat</label>
                            <textarea type="text" class="form-control" name="visi_kandidat" id="VisiKandidatEdit" placeholder="Masukan Visi Kandidat"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="MisiKandidatEdit">Misi Kandidat</label>
                            <textarea type="text" class="form-control" name="misi_kandidat" id="MisiKandidatEdit" placeholder="Masukan Misi Kandidat"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="PengalamanKandidatEdit">Pengalaman Kandidat</label>
                            <textarea type="text" class="form-control" name="pengalaman_kandidat" id="PengalamanKandidatEdit" placeholder="Masukan Pengalaman Kandidat"></textarea>
                        </div>
                        <div class="form-group text-center">
                            <label for="GambarPrevEdit">Gambar Kandidat</label><br>
                            <img id="GambarPrevEdit" src="" alt="Gambar Sebelumnya"><br>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="edit_image" id="GambarEditCheck" onclick="checkImageEdit()">
                                <label class="form-check-label">Edit Image</label>
                            </div>
                        </div>
                        <div id="GambarEditDiv" class="form-group" style="display: none">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="GambarKandidatEdit" name="image_kandidat">
                                    <label class="custom-file-label" id="GambarKandidatLabel" for="GambarKandidatEdit">Pilih gambar</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">Upload</span>
                                </div>
                            </div>
                            <small>Extensi gambar diharuskan JPG,JPEG,PNG dan maximal size 2MB</small>
                        </div>
                        <input type="hidden" id="kandidat_tim_id_edit" name="tim_id">
                        <input type="hidden" id="kandidat_id_edit" name="kandidat_id">
                        <input type="hidden" name="voting_id" value="1">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Edit Data</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


{{-- Modal Delete Kandidat --}}
    <div class="modal fade" id="modal_hapus_kandidat">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Hapus Kandidat</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda serius ingin menghapus Kandidat ini??</p>
                </div>
                <form action="{{ url('/administrator/kandidat/delkandidat') }}" method="post">
                    @csrf
                    <input type="hidden" id="kand_id" name="kand_id">
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Hapus Data</button>
                    </div>
                </form>
            </div>
        </div>
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
    function checkImageEdit() {
        var checkBox = document.getElementById("GambarEditCheck");
        var editDiv = document.getElementById('GambarEditDiv');
        if (checkBox.checked == true){
            editDiv.style.display = "block";
        } else {
            editDiv.style.display = "none";
        }
    }

    // Modal Hapus Tim
        $('#modal_hapus_tim').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var nama = button.data('nama')
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-title').text('Hapus Tim - ' + nama);
            document.getElementById("tim_id").value = id;
        });

    // Modal Edit Tim
        $('#modal_edit_tim').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var nama = button.data('nama')
            var semboyan = button.data('semboyan')
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-title').text('Edit Tim - ' + nama);
            document.getElementById("NamaTimEdit").value = nama;
            document.getElementById("SemboyanTimEdit").value = semboyan;
            document.getElementById("tim_id_edit").value = id;
        });


    // Modal Tambah Kandidat
        $('#modal_tambah_kandidat').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            document.getElementById("kandidat_tim_id").value = id;
        });

    // Modal Edit Kandidat
        $('#modal_edit_kandidat').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id');
            var nama = button.data('nama');
            var nim = button.data('nim');
            var jurusan = button.data('jurusan');
            var visi = button.data('visi');
            var misi = button.data('misi');
            var pengalaman = button.data('pengalaman');
            var image = button.data('image');
            var tim = button.data('tim');
            var modal = $(this);
            document.getElementById("kandidat_id_edit").value = id;
            document.getElementById("NamaKandidatEdit").value = nama;
            document.getElementById("NimKandidatEdit").value = nim;
            document.getElementById("JurusanKandidatEdit").value = jurusan;
            document.getElementById("VisiKandidatEdit").value = visi;
            document.getElementById("MisiKandidatEdit").value = misi;
            document.getElementById("PengalamanKandidatEdit").value = pengalaman;
            document.getElementById("GambarPrevEdit").src = "{{ asset('/image/kecil') }}" + '/' + image;
            document.getElementById("kandidat_tim_id_edit").value = tim;
        });

    // Modal Hapus Kandidat
        $('#modal_hapus_kandidat').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            document.getElementById("kand_id").value = id;
        });
</script>

@endsection
