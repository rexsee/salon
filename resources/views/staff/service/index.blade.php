@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Services
                        <a href="{{route('staff.service.add')}}" class="btn btn-sm btn-success pull-right">Add New</a>
                    </div>

                    <div class="card-body">
                        @include('flash::message')

                        <table id="datatable" class="table table-list">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Price</th>
                                <th>Description</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($result as $data)
                                <tr>
                                    <td>
                                        <a href="{{route('staff.service.edit',[$data->id])}}" class="btn btn-sm-2 btn-info">Edit</a>
                                        <a href="{{route('staff.service.delete',[$data->id])}}" onclick="return confirm('Are you sure to delete?')" class="btn btn-sm-2 btn-danger">Delete</a>
                                    </td>
                                    <td>{{$data->name}}</td>
                                    <td>{{$data->type}}</td>
                                    <td>{{$data->price}}</td>
                                    <td>{{str_limit($data->description,50)}}</td>
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