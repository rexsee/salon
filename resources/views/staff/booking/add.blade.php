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
                        Add New Customer
                        <a href="{{route('staff.customer')}}" class="btn btn-sm btn-outline-dark pull-right">Back</a>
                    </div>

                    <div class="card-body">
                        @include('flash::message')
                        @include('error_list')

                        {{ Form::open(['class' => 'form-horizontal']) }}
                        <div class="form-group row">
                            {{ Form::label('name', 'Name', ['class'=>'col-form-label col-sm-2']) }}
                            <div class="col-sm-10">
                                {{ Form::text('name', empty($customer) ? '' : $customer->name, ['class'=>'form-control', 'required']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('tel', 'Tel.', ['class'=>'col-form-label col-sm-2']) }}
                            <div class="col-sm-10">
                                {{ Form::tel('tel', empty($customer) ? '' : $customer->tel, ['class'=>'form-control', 'required']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('book_date', 'Date', ['class'=>'col-form-label col-sm-2']) }}
                            <div class="col-sm-10">
                                {{ Form::text('book_date', $book_date, ['class'=>'form-control datepicker', 'required']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('book_time', 'Time', ['class'=>'col-form-label col-sm-2']) }}
                            <div class="col-sm-10">
                                {{ Form::text('book_time', $book_time, ['class'=>'form-control timepicker', 'required']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('services', 'Services', ['class'=>'col-form-label col-sm-2']) }}
                            <div class="col-sm-10">
                                @foreach($serviceList as $key=>$name)
                                    <label>{{ Form::checkbox('services[]',$key,!empty($specialty) && in_array($key,$specialty) ? true : false) }}
                                        {{$name}}
                                    </label> &nbsp;
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('stylist', 'Stylist', ['class'=>'col-form-label col-sm-2']) }}
                            <div class="col-sm-10">
                                {{ Form::select('stylist', $stylistList, $stylist_id, ['class'=>'form-control']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                {{ Form::submit('Add', ['class'=>'btn btn-primary btn-block']) }}
                            </div>
                        </div>

                        {{ Form::close() }}
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
            minDate : "{{\Carbon\Carbon::now()->toDateTimeString()}}"
        });

        $('.timepicker').datetimepicker({
            format: 'LT',
            stepping: 30
        });
    </script>
@stop
