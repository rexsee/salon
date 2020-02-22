@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Stylists
                        <a href="{{route('staff.stylist.add')}}" class="btn btn-sm btn-success pull-right">Add New</a>
                    </div>

                    <div class="card-body">
                        @include('flash::message')

                        <table id="datatable" class="table table-list">
                            <thead>
                            <tr>
                                <th width="80px"></th>
                                <th>Status</th>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Is Stylist</th>
                                <th>Order</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($result as $data)
                                <tr>
                                    <td>
                                        <a href="{{route('staff.stylist.edit',[$data->id])}}" class="btn btn-sm-2 btn-info">Edit</a>
{{--                                        <a href="{{route('staff.stylist.delete',[$data->id])}}" onclick="return confirm('Are you sure to delete?')" class="btn btn-sm-2 btn-danger">Delete</a>--}}
                                    </td>
                                    <td>{{$data->status}}</td>
                                    <td>{{$data->name}}</td>
                                    <td>{{$data->title}}</td>
                                    <td>{{$data->is_stylist ? 'Yes' : 'No'}}</td>
                                    <td>{{$data->order}}</td>
                                    <td><img src="{{asset($data->avatar_path)}}" width="100px"/></td>
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
                order:[1,'asc']
            });
        } );
    </script>
@stop