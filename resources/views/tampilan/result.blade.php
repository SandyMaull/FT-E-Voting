@extends('tampilan.layouts.app')

@section('title')
    E-Voting Result
@endsection

@section('body')
    <div class="card">
        <div class="card-header result-header">
            Quick Count Voting Calon DPM FT
        </div>
        <div class="card-body result-body">
            <canvas id="donutChartDPM" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
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
            var namadpm = [];
            var votedpm = [];
            var colorsdpm = [];
            var fontsdpm = [];
            objkey = Object.keys(obj);
            for(i = 0; i < objkey.length; i++) {
                namadpm.push(obj[objkey[i]]['nama']);
                votedpm.push(obj[objkey[i]]['vote']);
                colorsdpm.push(obj[objkey[i]]['colors']);
                fontsdpm.push('white');
            }

        // DONUTCHARTDPM
            var donutChartCanvas = $('#donutChartDPM').get(0).getContext('2d')
            var donutData        = {
            labels: namadpm,
            datasets: [
                {
                data: votedpm,
                backgroundColor : colorsdpm,
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
                        fontColor: fontsdpm,
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