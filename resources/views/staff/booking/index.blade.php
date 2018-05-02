@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        @if(!empty($is_pending_list))
                            Pending Booking &nbsp;&nbsp;<a href="{{route('staff.booking')}}" class="small">(click to view all booking)</a>
                        @else
                            All Booking &nbsp;&nbsp;<a href="{{route('staff.booking',['type'=>'Pending'])}}" class="small">(click to view pending booking)</a>
                        @endif

                        <a href="{{route('staff.booking.add')}}" class="btn btn-sm btn-success pull-right">Add New</a>
                    </div>

                    <div class="card-body">
                        @include('flash::message')

                        <table id="datatable" class="table table-list">
                            <thead>
                            <tr>
                                <th width="80px"></th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th>Name</th>
                                <th>Tel</th>
                                <th>Book Date</th>
                                <th>Stylist</th>
                                <th>Services</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($result as $data)
                                <tr>
                                    <td>
                                        <a href="{{route('staff.booking.edit',[$data->id])}}" class="btn btn-sm-2 btn-info">Edit</a>
                                    </td>
                                    <td>{{$data->created_at}}</td>
                                    <td>{{$data->status}}</td>
                                    <td>{{$data->name}}</td>
                                    <td>{{$data->tel}}</td>
                                    <td>{{$data->booking_date->toDayDateTimeString()}}</td>
                                    <td>{{$data->stylist->name}}</td>
                                    <td>{{$data->services}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                autoWidth: false,
                responsive: true,
                pageLength: 50,
                columnDefs : [{ orderable: false, targets: 0 }],
                order:[1,'desc']
            });
        } );
    </script>
@stop