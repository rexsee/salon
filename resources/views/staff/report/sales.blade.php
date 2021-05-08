@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        @include('admin.elements.page_header')
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Sales</h3>
                                <div class="card-tools">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                                            {{ucfirst($salesGroup)}} Basic
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" role="menu">
                                            <a href="{{route('staff.report.sales',['sales'=>$salesYear,'sales_group'=>'monthly'])}}" class="dropdown-item">Monthly</a>
                                            <a href="{{route('staff.report.sales',['sales'=>$salesYear,'sales_group'=>'daily'])}}" class="dropdown-item">Daily</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="stackedBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Visit Count</h3>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="visitBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-default card-detail">
                            <div class="card-header">
                                <h3 class="card-title">Top Sales</h3>
                                <div class="card-tools">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                                            Year {{$salesYear}}
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" role="menu">
                                            @for($i = date('Y'); $i > (date('Y') - 4); $i--)
                                                <a href="{{route('staff.report.sales',['sales'=>$i,'sales_group'=>$salesGroup])}}" class="dropdown-item">{{$i}}</a>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Stylist</th>
                                        <th>Sales</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($topSales as $key => $value)
                                        <tr>
                                            <td>{{$key}}</td>
                                            <td>RM {{number_format($value)}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop

@section('js')
    <script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
    <script>
        $(function () {
            var areaChartData = {
                labels: ['{!! implode("','",$dates) !!}'],
                datasets: [
                    {
                        label: 'RM',
                        backgroundColor: 'rgb(46,114,32)',
                        borderColor: 'rgb(36,87,23)',
                        pointRadius: false,
                        pointColor: '#2e7220',
                        pointStrokeColor: 'rgb(46,114,32)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgb(46,114,32)',
                        data: [{!! implode(",",$amount) !!}]
                    },
                ]
            }
            var barChartData = jQuery.extend(true, {}, areaChartData)
            barChartData.datasets[0] = areaChartData.datasets[0]

            var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
            var stackedBarChartData = jQuery.extend(true, {}, barChartData)

            var stackedBarChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {xAxes: [{stacked: true,}], yAxes: [{stacked: true}]}
            }
            new Chart(stackedBarChartCanvas, {type: 'bar', data: stackedBarChartData, options: stackedBarChartOptions})


            var areaChartData2 = {
                labels: ['{!! implode("','",$dates) !!}'],
                datasets: [
                    {
                        label: 'Visits',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: [{!! implode(",",$visit) !!}]
                    },
                ]
            }
            var barChartData2 = jQuery.extend(true, {}, areaChartData2)
            barChartData2.datasets[0] = areaChartData2.datasets[0]

            var stackedBarChartCanvas2 = $('#visitBarChart').get(0).getContext('2d')
            var stackedBarChartData2 = jQuery.extend(true, {}, barChartData2)

            var stackedBarChartOptions2 = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {xAxes: [{stacked: true,}], yAxes: [{stacked: true}]}
            }
            new Chart(stackedBarChartCanvas2, {type: 'bar', data: stackedBarChartData2, options: stackedBarChartOptions2})
        });

    </script>
@stop
