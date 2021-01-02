@extends('admin.layouts.app')

@section('title')
Data Voting
@endsection

@section('css')
<!-- daterange picker -->
<link rel="stylesheet" href="{{ asset('admin_asset/plugins/daterangepicker/daterangepicker.css') }}">
<!-- Tempusdominus Bbootstrap 4 -->
<link rel="stylesheet"
    href="{{ asset('admin_asset/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection

@section('breadcrumb')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Data Voting</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Voting</li>
                    <li class="breadcrumb-item"><a href="{{ url('administrator/voting') }}">Data Voting</a></li>
                    <li class="breadcrumb-item active">Edit Data Voting</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('content')
<div class="card card-primary">
    <form action="{{ url('administrator/votingpost')}} " method="post">
        @csrf
        <div class="card-header">
        <h3 class="card-title">Data Voting</h3>
        </div>
        <div class="card-body">
            
            <div class="form-group">
                <label for="nama_voting">Nama Voting</label>
                <input type="text" name="nama_voting" class="form-control" id="nama_voting" placeholder="Masukan Nama Voting" value="{{ $voting->judul }}">
            </div>
            <div class="form-group">
                <label for="reservationdate">Tanggal Mulai Voting</label>
                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                    <input type="text" name="tglmulai_voting" class="tanggalmulai form-control datetimepicker-input" data-target="#reservationdate"  value="{{ $tglmulai }}">
                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="tgl_periode_voting">Periode Voting</label>
                <input type="text" name="periode_voting" class="form-control float-right" id="tgl_periode_voting" value="{{ $tglperiode }}">
            </div>
            <div class="form-group">
                <br>
                <br>
                <label for="stat_voting">Status Voting</label>
                    <input type="checkbox" id="stat_voting" name="voting_status_check" {{ $pending }} data-bootstrap-switch data-off-color="danger" data-on-color="success" data-on-text="Berjalan" data-off-text="Pending">
            </div>
            <div class="form-group">
                <label for="stat_pending_voting">Status Pending</label>
                <input type="text" name="pending_ket_voting" class="form-control float-right" value="{{ $stat_pending }}" id="stat_pending_voting">
            </div>
        </div>
        <div class="card-footer">
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>

@endsection

@section('script')
<!-- InputMask -->
<script src="{{ asset('admin_asset/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('admin_asset/plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
<!-- date-range-picker -->
<script src="{{ asset('admin_asset/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('admin_asset/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Bootstrap Switch -->
<script src="{{ asset('admin_asset/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<script>
    document.getElementById("datavoting").classList.add("menu-open");
    document.getElementById("datavoting_voting").classList.add("active");
    var today = new Date(); 
    var dd = today.getDate(); 
    var mm = today.getMonth()+1; //January is 0! 
    var yyyy = today.getFullYear(); 
    if(dd<10){ dd='0'+dd } 
    if(mm<10){ mm='0'+mm } 
    var today = yyyy+'/'+mm+'/'+dd; 
    //Date range picker

    $('#reservationdate').datetimepicker({
        format: "DD-MM-YYYY",
    });

    //Date range picker
    $('#tgl_periode_voting').daterangepicker({
        locale: {
            format: 'DD/M/YYYY'
        }
    });

    $("[name='voting_status_check']").bootstrapSwitch({
        function(event, state) {
            console.log(event);
        }
    });
    $('input[name="voting_status_check"]').on('switchChange.bootstrapSwitch', function(event, state) {
        // console.log(this); // DOM element
        // console.log(event); // jQuery event
        // console.log(state); // true | false
        var statpen = document.getElementById("stat_pending_voting");
        if(state) {
            statpen.disabled = true;
            statpen.value = '';
        }
        else {
            statpen.disabled = false;
            statpen.value = '{{ $stat_pending }}';
        }
    });

</script>

@endsection
