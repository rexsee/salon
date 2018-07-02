@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Add New Photo
                        <a href="{{route('staff.about_img')}}" class="btn btn-sm btn-outline-dark pull-right">Back</a>
                    </div>

                    <div class="card-body">
                        @include('error_list')

                        {{ Form::open(['class' => 'form-horizontal', 'id'=>'dform', 'enctype' => 'multipart/form-data']) }}
                        @include('staff.about_img.form')

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
