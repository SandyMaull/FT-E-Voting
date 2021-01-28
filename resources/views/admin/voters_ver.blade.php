@extends('admin.layouts.app')

@section('title')
Voters - Terverifikasi
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('admin_asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('admin_asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Voters - Terverifikasi</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Voters</li>
                    <li class="breadcrumb-item active">Terverifikasi</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Voters yang sudah terverifikasi</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="verifiedtables" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Prodi</th>
                            <th>Token</th>
                            <th>Foto Siakad</th>
                            <th>No.Telp</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($verif as $unv)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $unv->nama }}</td>
                                <td>{{ $unv->nim }}</td>
                                <td>{{ $unv->prodi }}</td>
                                <td>{{ $unv->token }}</td>
                                <td><a target="_blank" href="{{ url('/image/siakad'.'/'.$unv->foto_siakad) }}">Preview</a></td>
                                <td>{{ $unv->nmor_wa }}</td>
                                <td>
                                    <button type="button" data-id="{{ $unv->id }}" class="btn btn-danger" data-toggle="modal" data-target="#modal_revoke">
                                        Revoke Data
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Prodi</th>
                            <th>Token</th>
                            <th>Foto Siakad</th>
                            <th>No.Telp</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    {{ $verif->links() }}
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>


{{-- Modal Revoke Voters --}}
    <div class="modal fade" id="modal_revoke">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Revoke Voters</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('/admin/voters/revoke_verif') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        Apakah anda yakin ingin <strong>MEREVOKE</strong> data voter ini?
                        <input type="hidden" name="voters_id" id="id_voters_delete">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning">REVOKE Data</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@section('script')
<script src="{{ asset('admin_asset/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin_asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin_asset/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('admin_asset/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script>
    document.getElementById("datavoters").classList.add("menu-open");
    document.getElementById("datavoters_verified").classList.add("active");
    $(function () {
        $('#verifiedtables').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "responsive": true,
        });

    // Modal DELETE Voters
        $('#modal_revoke').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            document.getElementById("id_voters_delete").value = id;
        });
    });
</script>
@endsection
