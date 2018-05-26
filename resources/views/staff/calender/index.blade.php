@extends('layouts.app')
@section('css')
    <link href="{{asset('css/tempusdominus-bootstrap-4.min.css')}}" rel="stylesheet">
@stop

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        @if($is_day_view)
                            <a href="{{route('staff.calender',['today'=>0])}}" class="btn btn-sm btn-info pull-right">Switch to Date Range View</a>
                            {{ Form::open(['class' => 'form-inline','method'=>'get']) }}
                            <div class="form-group">
                                {{ Form::label('day', 'Day : ') }}
                                {{ Form::text('day', $day->format('d/m/Y'), ['class'=>'form-control form-control-sm datepicker', 'required','placeholder'=>'DD/MM/YYYY','autocomplete'=>'off']) }}
                            </div>
                            {{ Form::close() }}
                        @else
                            <a href="{{route('staff.calender',['today'=>1])}}" class="btn btn-sm btn-info pull-right">Switch to Day View</a>

                            {{ Form::open(['class' => 'form-inline','method'=>'get']) }}
                            <div class="form-group">
                                {{ Form::label('from_date', 'From : ') }}
                                {{ Form::text('from_date', $from->format('d/m/Y'), ['class'=>'form-control form-control-sm datepicker', 'required','placeholder'=>'DD/MM/YYYY','autocomplete'=>'off']) }}
                            </div>
                            &nbsp;&nbsp;&nbsp;
                            <div class="form-group">
                                {{ Form::label('to_date', 'To :') }}
                                {{ Form::text('to_date', $to->format('d/m/Y'), ['class'=>'form-control form-control-sm datepicker', 'required','placeholder'=>'DD/MM/YYYY','autocomplete'=>'off']) }}
                            </div>
                            {{ Form::close() }}
                        @endif

                    </div>

                    <div class="card-body">
                        @if($is_day_view)
                            <h4 style="background-color: #0a0a0a;color: #ffffff;padding: 2px 10px;margin-bottom: 0;margin-top: 20px;">{{$day->format('(D) d/m/Y')}}</h4>
                            <table class="table table-hover table-sm small">
                                <thead>
                                <tr>
                                    <th align="center" width="80px">Time</th>
                                    @foreach($stylists as $stylist)
                                        <th style="text-align: center !important;">{{$stylist}}</th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($time_range as $time_key=>$time)
                                    <tr>
                                        <td>{{$time}}</td>
                                        @foreach($stylists as $stylist_id => $stylist)
                                            <td align="center">
                                                @if(\Carbon\Carbon::now()->toDateString() < $day->toDateString() || (\Carbon\Carbon::now()->toDateString() == $day->toDateString() && \Carbon\Carbon::now()->format('Hi') <= $time_key))
                                                    <a href="{{route('staff.booking.add',['sid'=>$stylist_id,'bd'=>$day->format('d/m/Y'),'bt'=>$time])}}">
                                                        <i class="oi oi-plus"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="row">
                                @foreach($stylists as $stylist)
                                    <div class="col-sm mb-2">
                                        <a href="#{{str_slug($stylist)}}" class="btn btn-dark btn-block">{{$stylist}}</a>
                                    </div>
                                @endforeach
                            </div>
                            <hr />

                            @foreach($stylists as $stylist_id => $stylist)
                                <h4 id="{{str_slug($stylist)}}" style="background-color: #0a0a0a;color: #ffffff;padding: 2px 10px;margin-bottom: 0;margin-top: 20px;">{{$stylist}}</h4>
                                <table class="table table-hover table-sm small">
                                    <thead>
                                    <tr>
                                        <th align="center" width="80px">Time</th>
                                        @foreach($date_range as $day)
                                            <th style="text-align: center !important;">{{$day->format('(D) d/m/Y')}}</th>
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($time_range as $time_key=>$time)
                                        <tr>
                                            <td>{{$time}}</td>
                                            @foreach($date_range as $day)
                                                <td align="center">
                                                    @if(\Carbon\Carbon::now()->toDateString() < $day->toDateString() || (\Carbon\Carbon::now()->toDateString() == $day->toDateString() && \Carbon\Carbon::now()->format('Hi') <= $time_key))
                                                        <a href="{{route('staff.booking.add',['sid'=>$stylist_id,'bd'=>$day->format('d/m/Y'),'bt'=>$time,])}}">
                                                            <i class="oi oi-plus"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{asset('js/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <script>
        $('.datepicker').datetimepicker({
            format: 'DD/MM/YYYY',
        }).on('dp.change', function(e){ this.form.submit(); });
    </script>
@stop


