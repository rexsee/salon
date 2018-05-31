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
                        Edit Customer Log
                        <a href="{{route('staff.customer.detail',[$record->customer_id])}}" class="btn btn-sm btn-outline-dark pull-right">Back</a>
                    </div>

                    <div class="card-body">
                        @include('flash::message')
                        @include('error_list')

                        {{ Form::model($record,['class' => 'form-horizontal']) }}

                        @include('staff.customer.form_log')

                        <div class="form-group row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                {{ Form::submit('Edit', ['class'=>'btn btn-primary btn-block']) }}
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
            format: 'DD/MM/YYYY'
        });

        $('.timepicker').datetimepicker({
            format: 'LT',
            stepping: 30
        });
    </script>
@stop
