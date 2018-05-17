@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Edit Activity
                        <a href="{{route('staff.customer.detail',[$record->customer_id])}}" class="btn btn-sm btn-outline-dark pull-right">Back</a>
                    </div>

                    <div class="card-body">
                        @include('flash::message')
                        @include('error_list')

                        {{ Form::open(['class' => 'form-horizontal']) }}

                        <div class="form-group row">
                            {{ Form::label('activity_at', 'Activity At', ['class'=>'col-form-label col-sm-2']) }}
                            <div class="col-sm-10">
                                {{ Form::text('activity_at', $record->created_at->format('(D) d/m/Y H:i'), ['class'=>'form-control', 'readonly']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('services', 'Services', ['class'=>'col-form-label col-sm-2']) }}
                            <div class="col-sm-10">
                                {{ Form::text('services', $record->services, ['class'=>'form-control', 'readonly']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('remark', 'Remark', ['class'=>'col-form-label col-sm-2']) }}
                            <div class="col-sm-10">
                                {{ Form::textarea('remark', $record->remark, ['class'=>'form-control', 'required']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('stylist', 'Stylist', ['class'=>'col-form-label col-sm-2']) }}
                            <div class="col-sm-10">
                                {{ Form::select('stylist', $stylistList, $record->stylist_id, ['class'=>'form-control']) }}
                            </div>
                        </div>

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