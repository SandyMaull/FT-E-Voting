@extends('admin.layouts.app')

@section('title')
    Data Kandidat - Edit
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
                    <li class="breadcrumb-item"><a href="{{ url('administrator/kandidat') }}">Data Kandidat</a></li>
                    <li class="breadcrumb-item active">Edit Data Kandidat</li>
                </ol>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('content')
    Test
@endsection

@section('script')
    <script>
        var element = document.getElementById("dashboard");
        element.classList.add("active");
    </script>
@endsection