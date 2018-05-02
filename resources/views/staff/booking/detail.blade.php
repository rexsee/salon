@extends('layouts.app')
@section('css')
    <style>
        .customer-info tr td{
            padding-bottom: 10px;
            font-size: 10pt;
        }
        .panel-info {
            border: 1px solid cadetblue;
            border-radius: 5px;
        }

        .panel-info .panel-heading {
            background: lightblue;
            padding: 5px 10px;
        }

        .panel-info .panel-body {
            padding: 5px 10px;
            font-weight: 100;
            font-size: 10pt;
        }

        .panel-info .table td, .panel-info .table th
        {
            padding: 3px 5px;
        }
    </style>
@stop

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Detail about {{$record->name}}
                        <a href="{{route('staff.customer')}}" class="btn btn-sm btn-outline-dark pull-right">Back</a>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <table width="100%" class="customer-info">
                                    <tr>
                                        <td align="right" valign="top"><b>Name</b></td>
                                        <td> : {{$record->name}}</td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="top"><b>Tel.</b></td>
                                        <td> : {{$record->tel}}</td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="top"><b>Email</b></td>
                                        <td> : {{$record->email}}</td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="top"><b>DOB</b></td>
                                        <td> : {{$record->dob->toFormattedDateString()}}</td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="top"><b>Address</b></td>
                                        <td> : {{$record->address}}</td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="top"><b>City</b></td>
                                        <td> : {{$record->city}}</td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="top"><b>Allergies</b></td>
                                        <td> : {{$record->allergies}}</td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="top"><b>Remark</b></td>
                                        <td> : {{$record->remark}}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-8">
                                <div class="panel-info">
                                    <div class="panel-heading">
                                        Activities
                                    </div>
                                    <div class="panel-body">

                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Service</th>
                                                <th>Remark</th>
                                                <th>Stylist</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($activities as $activity)
                                                <tr>
                                                    <td width="100px">{{$activity->created_at->toFormattedDateString()}}</td>
                                                    <td width="150px">{{$activity->service->name}}</td>
                                                    <td>{{$activity->remark}}</td>
                                                    <td width="100px">{{$activity->stylist->name}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
