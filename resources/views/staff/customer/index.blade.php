@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        @if(!empty($type) && $type == 'birthday')
                            Birthday Month Customers &nbsp;&nbsp;<a href="{{route('staff.customer',['new'=>$new,'search'=>$search])}}" class="small">(click
                                to view all customer)</a>
                        @else
                            Customers &nbsp;&nbsp;<a href="{{route('staff.customer',['type'=>'birthday','new'=>$new,'search'=>$search])}}"
                                                     class="small">(click to view birthday month customer)</a>
                        @endif
                        <a href="{{route('staff.customer.sms_blast')}}" class="btn btn-sm btn-primary pull-right" style="margin-left: 10px;">SMS Blast</a>
                        <a href="{{route('staff.customer.export')}}" class="btn btn-sm btn-info pull-right" style="margin-left: 10px;">Export</a>
                        <a href="{{route('staff.customer.add')}}" class="btn btn-sm btn-success pull-right" style="margin-left: 10px;">Add New</a>
                        <a href="{{route('staff.customer',['type'=>$type,'search'=>$search,'new'=>'7days'])}}" class="btn btn-sm btn-default pull-right {{ $new == '7days' ? 'text-dark' : ''}}" style="margin-left: 10px;">7 Days New Customer List</a>
                        <a href="{{route('staff.customer',['type'=>$type,'search'=>$search,'new'=>'today'])}}" class="btn btn-sm btn-default pull-right {{$new == 'today' ? 'text-dark' : ''}}" style="margin-left: 10px;">Today New Customer List</a>
                        <a href="{{route('staff.customer',['type'=>$type,'search'=>$search,'new'=>''])}}" class="btn btn-sm btn-default pull-right {{empty($new) ? 'text-dark' : ''}}">All Customer List</a>

                    </div>

                    <div class="card-body">
                        @include('flash::message')

                        <form method="get">
                            <input style="width: 300px" name="search" value="{{$search}}" type="text" placeholder="search by name, tel, city, or stylist" />
                            <input type="hidden" name="type" value="{{$type}}" />
                            <input type="hidden" name="new" value="{{$new}}" />
                            <input type="hidden" name="sort_by" value="{{$sort_by}}" />
                            <input type="hidden" name="sort" value="{{$sort}}" />

                            <input type="submit" value="Search" />
                        </form>

                        <table class="table table-list small">
                            <thead>
                            <tr>
                                <th width="80px"></th>
                                <th>{!! component_sort_link(route('staff.customer',['type'=>$type,'new'=>$new,'search'=>$search]),'Name','name',$sort_by,$sort) !!}</th>
                                <th>{!! component_sort_link(route('staff.customer',['type'=>$type,'new'=>$new,'search'=>$search]),'Tel','tel',$sort_by,$sort) !!}</th>
                                <th>{!! component_sort_link(route('staff.customer',['type'=>$type,'new'=>$new,'search'=>$search]),'Gender','gender',$sort_by,$sort) !!}</th>
                                <th>{!! component_sort_link(route('staff.customer',['type'=>$type,'new'=>$new,'search'=>$search]),'City','city',$sort_by,$sort) !!}</th>
                                <th>{!! component_sort_link(route('staff.customer',['type'=>$type,'new'=>$new,'search'=>$search]),'DOB','dob',$sort_by,$sort) !!}</th>
                                <th>{!! component_sort_link(route('staff.customer',['type'=>$type,'new'=>$new,'search'=>$search]),'Last Visit','last_visit_at',$sort_by,$sort) !!}</th>
                                <th>{!! component_sort_link(route('staff.customer',['type'=>$type,'new'=>$new,'search'=>$search]),'Created At','created_at',$sort_by,$sort) !!}</th>
                                <th>Remark</th>
                                <th>Stylist</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($result as $data)
                                <tr>
                                    <td>
                                        <a href="{{route('staff.customer.add_log',['id'=>$data->id])}}"
                                           class="btn btn-sm-2 btn-success">Add Log</a>
                                        <a href="{{route('staff.customer.edit',[$data->id])}}"
                                           class="btn btn-sm-2 btn-info">Edit</a>
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
                                    <td>{{$data->dob ? $data->dob->toFormattedDateString() : '-'}}</td>
                                    <td>{{$data->last_visit_at}}</td>
                                    <td>{{$data->created_at->toDateString()}}</td>
                                    <td>{{$data->remark}}</td>
                                    <td>{{empty($data->stylist) ? ' - ' : $data->stylist->name}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{ $result->appends(['type'=>$type,'new'=>$new,'sort_by'=>$sort_by,'sort'=>$sort,'search'=>$search])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection