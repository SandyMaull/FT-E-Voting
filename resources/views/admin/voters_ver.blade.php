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
                                <td><a href="{{ url('/image/siakad'.'/'.$unv->foto_siakad) }}">Preview</a></td>
                                <td>{{ $unv->nmor_wa }}</td>
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
                        </tr>
                    </tfoot>
                    {{ $verif->links() }}
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
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
    });
</script>
@endsection
