@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Booking
                        <a href="{{route('staff.booking.add')}}" class="btn btn-sm btn-success pull-right">Add New</a>
                    </div>

                    <div class="card-body">
                        @include('flash::message')

                        <table id="datatable" class="table table-list">
                            <thead>
                            <tr>
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
                                        @if($data->status == 'Done')
                                            <span class="badge badge-success">{{$data->status}}</span>
                                        @elseif($data->status == 'Confirmed' || $data->status == 'Postpone')
                                            <a href="{{route('staff.booking.update',[$data->id])}}" class="btn btn-sm-2 btn-info">{{$data->status}}</a>
                                        @else
                                            <span class="badge badge-danger">{{$data->status}}</span>
                                        @endif
                                    </td>
                                    <td>{{$data->name}}</td>
                                    <td>{{$data->tel}}</td>
                                    <td>{{$data->booking_date->format('(D) d/m/Y H:i')}}</td>
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
                order:[3,'desc']
            });
        } );
    </script>
@stop