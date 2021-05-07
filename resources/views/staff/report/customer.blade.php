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
                                <h3 class="card-title">New Customer</h3>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="stackedBarChart"
                                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Gender</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="genderChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Category</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="categoryChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Stylist</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="stylistChart" style="min-height: 700px; height: 700px; max-height: 700px; max-width: 100%;"></canvas>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">City</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="cityChart" style="min-height: 700px; height: 700px; max-height: 700px; max-width: 100%;"></canvas>
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
            var cityChartCanvas = $('#cityChart').get(0).getContext('2d')
            var cityData = {
                labels: ['{!! implode("','",array_keys($cityData)) !!}'],
                datasets: [
                    {
                        data: [{!! implode(",",$cityData) !!}],
                        backgroundColor: ['@foreach($cityData as $k => $v){!! getReportColor($k) !!}', '@endforeach'],
                    }
                ]
            }
            var cityOptions = {maintainAspectRatio: false, responsive: true,}
            new Chart(cityChartCanvas, {type: 'pie', data: cityData, options: cityOptions})



            var genderChartCanvas = $('#genderChart').get(0).getContext('2d')
            var genderData = {
                labels: ['{!! implode("','",array_keys($genderData)) !!}'],
                datasets: [
                    {
                        data: [{!! implode(",",$genderData) !!}],
                        backgroundColor: ['@foreach($genderData as $k => $v){!! getReportColor($k) !!}', '@endforeach'],
                    }
                ]
            }
            var genderOptions = {maintainAspectRatio: false, responsive: true,}
            new Chart(genderChartCanvas, {type: 'pie', data: genderData, options: genderOptions})




            var categoryChartCanvas = $('#categoryChart').get(0).getContext('2d')
            var categoryData = {
                labels: ['{!! implode("','",array_keys($categoryData)) !!}'],
                datasets: [
                    {
                        data: [{!! implode(",",$categoryData) !!}],
                        backgroundColor: ['@foreach($categoryData as $k => $v){!! getReportColor($k) !!}', '@endforeach'],
                    }
                ]
            }
            var categoryOptions = {maintainAspectRatio: false, responsive: true,}
            new Chart(categoryChartCanvas, {type: 'pie', data: categoryData, options: categoryOptions})



            var stylistChartCanvas = $('#stylistChart').get(0).getContext('2d')
            var stylistData = {
                labels: ['{!! implode("','",array_keys($stylistData)) !!}'],
                datasets: [
                    {
                        data: [{!! implode(",",$stylistData) !!}],
                        backgroundColor: ['@foreach($stylistData as $k => $v){!! getReportColor($k) !!}', '@endforeach'],
                    }
                ]
            }
            var stylistOptions = {maintainAspectRatio: false, responsive: true,}
            new Chart(stylistChartCanvas, {type: 'pie', data: stylistData, options: stylistOptions})




            var areaChartData = {
                labels: ['{!! implode("','",array_keys($register)) !!}'],
                datasets: [
                    {
                        label: 'Customer',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: [{!! implode(",",$register) !!}]
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
        });

    </script>
@stop
