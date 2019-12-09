@extends('layouts.app')

@section('css')
    <link href="{{asset('css/tempusdominus-bootstrap-4.min.css')}}" rel="stylesheet">
@stop

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Follow Up Customer List
                        <a href="{{route('staff.customer')}}" class="btn btn-sm btn-default pull-right">All Customer List</a>

                    </div>

                    <div class="card-body">
                        @include('flash::message')
                        <div class="text-right">
                            <form method="get">
                                Follow Up Date Range :
                                {{ Form::text('from_date', empty($from_date) ? '' : $from_date, ['class'=>'datepicker', 'placeholder'=>'From Date']) }} to
                                {{ Form::text('to_date', empty($to_date) ? '' : $to_date, ['class'=>'datepicker', 'placeholder'=>'To Date']) }}
                                <input type="submit" value="Filter" />
                            </form>
                            <br />
                        </div>

                        @if(count($result))
                        <table id="datatable" class="table table-list small">
                            <thead>
                            <tr>
                                <th width="80px"></th>
                                <th>Name</th>
                                <th>Tel</th>
                                <th>Gender</th>
                                <th>City</th>
                                <th>Last Visit</th>
                                <th>Follow Up</th>
                                <th>Already Follow Up?</th>
                                <th>Last Log Remark</th>
                                <th>Stylist</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($result as $data)
                                <tr>
                                    <td>
                                        @if(!$data->is_follow_up)
                                        <a href="{{route('staff.customer.follow_up_update',[$data->id])}}"
                                           class="btn btn-sm-2 btn-info">Mark as followed up</a>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('staff.customer.detail',[$data->id])}}">{{$data->name}}</a>

                                        @if(!empty($data->dob) && $data->dob->format('m') == date('m'))
                                            <span class="oi oi-star" style="color: green"></span>
                                        @endif
                                    </td>
                                    <td>{{$data->tel}}</td>
                                    <td>{{$data->gender}}</td>
                                    <td>{{$data->city}}</td>
                                    <td>{{$data->last_visit_at}}</td>
                                    <td>{{$data->follow_up_date ? $data->follow_up_date->toDateString() : ' - '}}</td>
                                    <td>{{$data->is_follow_up ? 'Yes' : 'No'}}</td>
                                    <td>{{empty($data->logs()->latest()->first()->remark) ? ' - ' : $data->logs()->latest()->first()->remark}}</td>
                                    <td>{{empty($data->stylist) ? ' - ' : $data->stylist->name}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @else
                            <p style="text-align: center">No record found</p>
                        @endif
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
        $(document).ready(function() {
            $('#datatable').DataTable({
                autoWidth: false,
                responsive: true,
                pageLength: 50,
                columnDefs : [{ orderable: false, targets: 0 }],
                order:[3,'desc']
            });
        } );
        $('.datepicker').datetimepicker({
            format: 'DD/MM/YYYY'
        });
    </script>
@stop
