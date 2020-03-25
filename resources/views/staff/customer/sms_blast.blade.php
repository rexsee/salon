@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        SMS Blast
                        @if(!empty($sms_balance))
                        (You have {{$sms_balance}} SMS remaining)
                        @endif
                        <a href="{{route('staff.customer')}}" class="btn btn-sm btn-outline-dark pull-right">Back</a>
                    </div>

                    <div class="card-body">
                        @include('flash::message')
                        @include('error_list')

                        {{ Form::open(['class' => 'form-horizontal', 'id'=>'dform']) }}

                        <div class="form-group row">
                            {{ Form::label('title', 'Blast Title', ['class'=>'col-form-label col-sm-2']) }}
                            <div class="col-sm-10">
                                {{ Form::text('title', 'SMS blast at ' . \Carbon\Carbon::now()->toDateString(), ['class'=>'form-control', 'required']) }}
                            </div>
                        </div>

                        @if(empty($id))
                        <div class="form-group row">
                            {{ Form::label('customer_group', 'Customer Group', ['class'=>'col-form-label col-sm-2']) }}
                            <div class="col-sm-10">
                                <label>{{ Form::radio('customer_group','male') }} Male Customer ({{$count_male}} SMS will send)</label> <br />
                                <label>{{ Form::radio('customer_group','female') }} Female Customer ({{$count_female}} SMS will send)</label> <br />
                                <label>{{ Form::radio('customer_group','birthday') }} Birthday Month Customer ({{$count_birthday}} SMS will send)</label> <br />
                                <label>{{ Form::radio('customer_group','all') }} All Customer ({{$count_all}} SMS will send)</label> <br />
                            </div>
                        </div>
                        @else
                            <input type="hidden" name="customer_group" value="id">
                            <input type="hidden" name="id" value="{{$id}}">
                        @endif

                        <div class="form-group row">
                            {{ Form::label('message', 'SMS Message', ['class'=>'col-form-label col-sm-2']) }}
                            <div class="col-sm-10">
                                {{ Form::textarea('message', null, ['class'=>'form-control', 'required','rows'=>3,'placeholder'=>'Make it within 160 letters for send using one SMS...']) }}
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

                @if(count($blast_list))
                    <br /><br />
                    <div class="card">
                        <div class="card-header">SMS Blast Sending List</div>

                        <div class="card-body">
                            <table class="table small">
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Created At</th>
                                    <th>Remaining to send</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($blast_list as $item)
                                    <tr>
                                        <td>{{$item['title']}}</td>
                                        <td>{{$item['created_at']}}</td>
                                        <td>{{$item['count']}}</td>
                                        <td><a href="{{route('staff.customer.sms_delete',[$item['key']])}}" class="btn btn-sm btn-danger">Delete</a> </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                @endif

                @if(count($blast_fail_list))
                    <br /><br />
                    <div class="card">
                        <div class="card-header">SMS Failed to Send List</div>

                        <div class="card-body">
                            <table class="table small">
                                <thead>
                                <tr>
                                    <th>Tel</th>
                                    <th>Message</th>
                                    <th>Retry Count</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($blast_fail_list as $item)
                                    <tr>
                                        <td>{{$item['tel']}}</td>
                                        <td>{{$item['message']}}</td>
                                        <td>{{$item['retry']}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection