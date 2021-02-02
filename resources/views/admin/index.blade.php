@extends('admin.layouts.app')

@section('title')
    Dashboard
@endsection

@section('breadcrumb')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            @if ($votingstat == 'Belum Dimulai')
                <div class="small-box bg-info">
            @elseif ($votingstat == 'Sudah Berakhir')
                <div class="small-box bg-danger">
            @elseif ($votingstat == 'Berjalan')
                <div class="small-box bg-success">
            @else
                <div class="small-box bg-warning">
            @endif
                <div class="inner">
                    <h3>{{ $votingstat }}</h3>

                    <p>Voting Status</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <a href="{{ url('/administrator/voting') }}" class="small-box-footer">Lihat Data <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $kandidattotal }}</h3>

                    <p>Data Kandidat</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-friends"></i>
                </div>
                <a href="{{ url('/administrator/kandidat') }}" class="small-box-footer">Lihat List<i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $verifiedvoters }}</h3>

                    <p>User Terverifikasi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ url('/admin/voters/verif') }}" class="small-box-footer">Lihat List <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $unverifvoters }}</h3>

                    <p>User Belum Terverifikasi</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ url('/admin/voters/unverif') }}" class="small-box-footer">Lihat List <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-chart-pie mr-1"></i>
                Total Suara BEM
            </h3>
        </div>
        <div class="card-body">
            <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('admin_asset/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>
    <script>
        var element = document.getElementById("dashboard");
        element.classList.add("active");

        //-------------
        //- DONUT CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
        var donutData        = {
        labels: [
            'PASLON 1', 
            'PASLON 2',
        ],
        datasets: [
            {
            data: [700,500],
            backgroundColor : ['#00a65a', '#f56954'],
            }
        ]
        }
        var donutOptions = {
            maintainAspectRatio : false,
            responsive : true,
            tooltips: {
                enabled: false
            },
            plugins: {
                labels: {
                    render: 'percentage',
                    fontColor: ['green', 'white', 'red'],
                    precision: 2
                }
            }
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        var donutChart = new Chart(donutChartCanvas, {
        type: 'pie',
        data: donutData,
        options: donutOptions      
        });
    </script>
@endsection