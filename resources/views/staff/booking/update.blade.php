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
                        {{$record->name}}'s Booking
                        <a href="javascript:history.back()" class="btn btn-sm btn-outline-dark pull-right">Back</a>
                    </div>

                    <div class="card-body">
                        <div class="row justify-content-md-center">
                            <div class="col-md">
                                <div class="card">
                                    <div class="card-body">
                                        <b>Booking Date</b> : {{$record->booking_date->format('(D) d/m/Y H:i')}} <br />
                                        <b>Customer</b> : {{$record->tel}} ({{$record->name}})<br />
                                        <b>Stylist</b> : {{$record->stylist->name}}<br />
                                        <b>Services</b> : {{$record->services}}<br />
                                        @if($record->status == 'Postpone')
                                            <span style="color: red">This customer has postpone before</span>
                                        @endif
                                    </div>
                                </div>
                                <br />
                            </div>
                        </div>

                        @include('error_list')

                        <div class="row">
                            <div class="col-md">
                                <div class="card" style="border: 1px solid blue">
                                    <div class="card-body">
                                        <h5 class="card-title" style="color: blue;">Postpone Booking</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">postpone booking to the given date below</h6>
                                        {{ Form::model($record,['class' => 'form-horizontal']) }}

                                        <div class="form-group">
                                            {{ Form::label('postpone_date', 'Date', ['class'=>'col-form-label']) }}
                                            {{ Form::text('postpone_date', null, ['class'=>'form-control datepicker','placeholder'=>'MM/DD/YYYY']) }}
                                        </div>

                                        <div class="form-group">
                                            {{ Form::label('postpone_time', 'Time', ['class'=>'col-form-label']) }}
                                            {{ Form::text('postpone_time', null, ['class'=>'form-control timepicker','placeholder'=>'HH:MM']) }}
                                        </div>

                                        <div class="form-group">
                                            {{ Form::submit('Postpone Booking', ['class'=>'btn btn-primary btn-block']) }}
                                        </div>

                                        {{ Form::hidden('update_to','Postpone') }}
                                        {{ Form::close() }}
                                    </div>
                                </div>
                                <br />
                            </div>
                            <div class="col-md">
                                <div class="card" style="border: 1px solid red">
                                    <div class="card-body">
                                        <h5 class="card-title" style="color: red;">Cancel Booking</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">cancel the booking</h6>
                                        {{ Form::model($record,['class' => 'form-horizontal']) }}

                                        <br /><br />
                                        <div class="form-group">
                                            {{ Form::submit('Cancel Booking', ['class'=>'btn btn-danger btn-block']) }}
                                        </div>

                                        {{ Form::hidden('update_to','Cancel') }}
                                        {{ Form::close() }}
                                    </div>
                                </div>
                                <br />
                            </div>
                        </div>
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
            defaultDate: "{{$record->booking_date->toDateTimeString()}}",
            minDate : "{{$record->booking_date->toDateTimeString()}}"
        });

        $('.timepicker').datetimepicker({
            format: 'LT',
            defaultDate: "{{$record->booking_date->toDateTimeString()}}",
            minDate : "{{$record->booking_date->toDateTimeString()}}"
        });
    </script>
@stop
