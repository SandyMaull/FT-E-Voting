@extends('tampilan.layouts.app')

@section('title')
    E-Voting Result
@endsection

@section('body')
    <div class="card cardawalresult">
        <div class="card-header result-header">
            Quick Count Voting Calon DPM FT
        </div>
        <div class="card-body result-body">
            <div class="container">
                <div class="row">
                    <div class="col col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                Calon DPM FT Jurusan Teknik Elektro
                            </div>
                            <div class="card-body">
                                <canvas id="donutChartDPMElektro" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                Calon DPM FT Jurusan Teknik Sipil
                            </div>
                            <div class="card-body">
                                <canvas id="donutChartDPMSipil" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer result-footer">
            *Hasil Quick Count bersifat Mutlak
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('admin_asset/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>
    <script>
        //GET DATA FROM CONTROLLER
            var dpm = "{{ $dpmdata }}";
            var obj = JSON.parse(JSON.stringify(dpm));
            obj = obj.replace(/&quot;/g, '"');
            obj = JSON.parse(obj);
            var prodidpm = [];
            var namadpm1 = [];
            var votedpm1 = [];
            var colorsdpm1 = [];
            var fontsdpm1 = [];
            var namadpm2 = [];
            var votedpm2 = [];
            var colorsdpm2 = [];
            var fontsdpm2 = [];
            objkey = Object.keys(obj);
            // console.log(obj[objkey[1]]);
            for(i = 0; i < objkey.length; i++) {
                if (obj[objkey[i]]['jurusan'] == 'Teknik Elektro') {
                    namadpm1.push(obj[objkey[i]]['nama']);
                    votedpm1.push(obj[objkey[i]]['vote']);
                    colorsdpm1.push(obj[objkey[i]]['colors']);
                    fontsdpm1.push('white');
                } else if (obj[objkey[i]]['jurusan'] == 'Teknik Sipil') {
                    namadpm2.push(obj[objkey[i]]['nama']);
                    votedpm2.push(obj[objkey[i]]['vote']);
                    colorsdpm2.push(obj[objkey[i]]['colors']);
                    fontsdpm2.push('white');
                }
                // console.log(obj[objkey[i]]['jurusan']);
            }

        // DONUTCHARTDPM Elektro
        var donutChartCanvas = $('#donutChartDPMElektro').get(0).getContext('2d')
            var donutData        = {
            labels: namadpm1,
            datasets: [
                {
                data: votedpm1,
                backgroundColor : colorsdpm1,
                }
            ]
            }
            var donutOptions = {
                maintainAspectRatio : false,
                responsive : true,
                tooltips: {
                    enabled: true
                },
                plugins: {
                    labels: {
                        render: 'percentage',
                        fontColor: fontsdpm1,
                        precision: 2
                    }
                }
            }
            var donutChart = new Chart(donutChartCanvas, {
            type: 'pie',
            data: donutData,
            options: donutOptions      
            });

        // DONUTCHARTDPM Sipil
            var donutChartCanvas = $('#donutChartDPMSipil').get(0).getContext('2d')
            var donutData        = {
            labels: namadpm2,
            datasets: [
                {
                data: votedpm2,
                backgroundColor : colorsdpm2,
                }
            ]
            }
            var donutOptions = {
                maintainAspectRatio : false,
                responsive : true,
                tooltips: {
                    enabled: true
                },
                plugins: {
                    labels: {
                        render: 'percentage',
                        fontColor: fontsdpm2,
                        precision: 2
                    }
                }
            }
            var donutChart = new Chart(donutChartCanvas, {
            type: 'pie',
            data: donutData,
            options: donutOptions      
            });

        // REFRESH PAGE EVERY 1 MINUTES 
            setTimeout(function() {
                location.reload();
            }, 100000);
    </script>
@endsection