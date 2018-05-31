@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">Edit Profile</div>

                    <div class="card-body">

                        @include('flash::message')
                        @include('error_list')

                        {{ Form::model(auth()->user(),['class' => 'form-horizontal']) }}

                        <div class="form-group row">
                            {{ Form::label('name', 'Name', ['class'=>'col-form-label col-sm-2']) }}
                            <div class="col-sm-10">
                                {{ Form::tel('name', null, ['class'=>'form-control','required']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('current_password', 'Current Password', ['class'=>'col-form-label col-sm-2']) }}
                            <div class="col-sm-10">
                                {{ Form::password('current_password', ['class'=>'form-control','required']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('new_password', 'New Password', ['class'=>'col-form-label col-sm-2']) }}
                            <div class="col-sm-10">
                                {{ Form::password('new_password', ['class'=>'form-control','required','placeholder'=>'Enter your new password']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('new_password_confirmation', 'New Password Confirm', ['class'=>'col-form-label col-sm-2']) }}
                            <div class="col-sm-10">
                                {{ Form::password('new_password_confirmation', ['class'=>'form-control','required','placeholder'=>'Enter your new password again.']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                {{ Form::submit('Update', ['class'=>'btn btn-primary btn-block']) }}
                            </div>
                        </div>

                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
