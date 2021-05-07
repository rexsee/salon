@extends('layouts.admin')
@section('style')
    <style>
        .card-detail hr {
            margin: .5rem 0;
        }
        .card-detail .card-body {
            line-height: 1.1rem;
        }
    </style>
@stop
@section('content')
    <div class="content-wrapper">
        @include('admin.elements.page_header')
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Overall View Count</h3>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="stackedBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">View Count by Category</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-default card-detail">
                            <div class="card-header">
                                <h3 class="card-title">Most Viewed Courses</h3>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Course</th>
                                        <th>Views</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($topCourse as $item)
                                        <tr>
                                            <td>{{getSelectedLangValue($courseNames[$item->course_id])}}</td>
                                            <td>{{number_format($item->total)}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-default card-detail">
                            <div class="card-header">
                                <h3 class="card-title">Most Viewed Courses in the last 30 days</h3>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Course</th>
                                        <th>Views</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($topCourseM as $item)
                                        <tr>
                                            <td>{{getSelectedLangValue($courseNames[$item->course_id])}}</td>
                                            <td>{{number_format($item->total)}}</td>
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
            //-------------
            //- DONUT CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
            var donutData        = {
                labels: ['{!! implode("','",array_keys($category)) !!}'],
                datasets: [
                    {
                        data: [{!! implode(",",$category) !!}],
                        backgroundColor : ['@foreach($category as $k => $v){!! getReportColor($k) !!}','@endforeach'],
                    }
                ]
            }
            var donutOptions     = {
                maintainAspectRatio : false,
                responsive : true,
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            var donutChart = new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutData,
                options: donutOptions
            })

            var areaChartData = {
                labels  : ['{!! implode("','",array_keys($overall)) !!}'],
                datasets: [
                    {
                        label               : 'views',
                        backgroundColor     : 'rgba(60,141,188,0.9)',
                        borderColor         : 'rgba(60,141,188,0.8)',
                        pointRadius          : false,
                        pointColor          : '#3b8bba',
                        pointStrokeColor    : 'rgba(60,141,188,1)',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data                : [{!! implode(",",$overall) !!}]
                    },
                ]
            }
            var barChartData = jQuery.extend(true, {}, areaChartData)
            barChartData.datasets[0] = areaChartData.datasets[0]

            //---------------------
            //- STACKED BAR CHART -
            //---------------------
            var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
            var stackedBarChartData = jQuery.extend(true, {}, barChartData)

            var stackedBarChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                scales: {
                    xAxes: [{
                        stacked: true,
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                }
            }

            var stackedBarChart = new Chart(stackedBarChartCanvas, {
                type: 'bar',
                data: stackedBarChartData,
                options: stackedBarChartOptions
            })
        });

    </script>
@stop
