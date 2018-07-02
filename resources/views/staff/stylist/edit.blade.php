@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Edit Stylist
                        <a href="{{route('staff.stylist')}}" class="btn btn-sm btn-outline-dark pull-right">Back</a>
                    </div>

                    <div class="card-body">
                        @include('error_list')

                        {{ Form::model($record,['class' => 'form-horizontal', 'id'=>'dform', 'enctype' => 'multipart/form-data']) }}
                        @include('staff.stylist.form')

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
