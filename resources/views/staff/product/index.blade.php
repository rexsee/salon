@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Product
                        <a href="{{route('staff.product.add')}}" class="btn btn-sm btn-success pull-right">Add New</a>
                    </div>

                    <div class="card-body">
                        @include('flash::message')

                        <table id="datatable" class="table table-list">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Created At</th>
                                <th>Name</th>
                                <th>Is Active?</th>
                                <th>Price</th>
                                <th>Image</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($result as $data)
                                <tr>
                                    <td>
                                        <a href="{{route('staff.product.edit',[$data->id])}}" class="btn btn-sm-2 btn-info">Edit</a>
                                        <a href="{{route('staff.product.delete',[$data->id])}}" onclick="return confirm('Are you sure to delete?')" class="btn btn-sm-2 btn-danger">Delete</a>
                                    </td>
                                    <td>{{$data->created_at->toDateString()}}</td>
                                    <td>{{$data->name}}</td>
                                    <td>{{$data->is_active ? 'Yes' : 'No'}}</td>
                                    <td>{{$data->price}}</td>
                                    <td><img src="{{asset($data->image_path)}}" width="100px"/></td>
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
                pageLength: 25,
                columnDefs : [{ orderable: false, targets: 0 }],
                order:[1,'asc']
            });
        } );
    </script>
@stop
