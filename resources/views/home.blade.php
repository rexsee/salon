@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if(count($birthday_customer))
                        <div class="jumbotron">
                            <h1>Birthday Reminder</h1>
                            <p>There is <b>{{$birthday_customer}}</b> customer(s) birthday this month.</p>
                            <p><a class="btn btn-primary btn-lg" href="{{route('staff.customer',['type'=>'birthday'])}}" role="button">Check it out</a></p>
                        </div>

                        <div>

                        </div>
                    @endif

                    @include('flash::message')
                    @include('error_list')

                    {{ Form::model($record,['class' => 'form-horizontal']) }}
                    <div class="form-group row">
                        {{ Form::label('address', 'Address', ['class'=>'col-form-label col-sm-2']) }}
                        <div class="col-sm-10">
                            {{ Form::text('address', old('address'), ['class'=>'form-control', 'required']) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        {{ Form::label('contact_number', 'Contact No.', ['class'=>'col-form-label col-sm-2']) }}
                        <div class="col-sm-10">
                            {{ Form::tel('contact_number', old('contact_number'), ['class'=>'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        {{ Form::label('fax_number', 'Fax No.', ['class'=>'col-form-label col-sm-2']) }}
                        <div class="col-sm-10">
                            {{ Form::tel('fax_number', old('fax_number'), ['class'=>'form-control','placeholder'=>'optional']) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        {{ Form::label('email', 'Email', ['class'=>'col-form-label col-sm-2']) }}
                        <div class="col-sm-10">
                            {{ Form::email('email', old('email'), ['class'=>'form-control','placeholder'=>'optional']) }}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('head_line', 'Head Line', ['class'=>'col-form-label col-sm-2']) }}
                        <div class="col-sm-10">
                            {{ Form::text('head_line', old('head_line'), ['class'=>'form-control','required']) }}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('slogan', 'Slogan', ['class'=>'col-form-label col-sm-2']) }}
                        <div class="col-sm-10">
                            {{ Form::text('slogan', old('slogan'), ['class'=>'form-control','required']) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            {{ Form::submit('Edit Website Info', ['class'=>'btn btn-primary btn-block']) }}
                        </div>
                    </div>

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
