@extends('layouts.admin')

@section('style')
    <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
@stop

@section('content')
    <div class="content-wrapper">
        @include('admin.elements.page_header')

        <section class="content">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        @include('admin.elements._filter_bar' )
                        <small class="pull-right text-gray">search by name, tel and remark only.</small>
                    </div>
                </div>
                <div class="card-body">
                    @if(!empty($data))
                        <div class="mb-2">
                            <a href='{{route('staff.customer.export', request()->query())}}' class='btn btn-default btn-sm'>Export</a> &nbsp;
                            <a href='{{route('staff.customer.export', ['islog'=>1] + request()->query())}}' class='btn btn-default btn-sm'>Export With Log Detail</a> &nbsp;
                        </div>
                    @endif

                    <table id="datatable" class="table table-bordered table-hover text-xs">
                        <thead>
                        <tr>
                            <th width="100px">{{sort_link('Name','name')}}</th>
                            <th width="60px">{{sort_link('Tel','tel')}}</th>
                            <th width="60px">{{sort_link('Gender','gender')}}</th>
                            <th width="60px">{{sort_link('City','city')}}</th>
                            <th width="70px">{{sort_link('DOB','dob')}}</th>
                            <th width="50px">{{sort_link('Visits','visit_count')}}</th>
                            <th width="50px">{{sort_link('Spent','total_spent')}}</th>
                            <th width="70px">{{sort_link('Visited','last_visit_at')}}</th>
                            <th width="70px">{{sort_link('Created','created_at')}}</th>
                            <th>Remark</th>
                            <th width="80px">Stylist</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $record)
                            <tr>
                                <td>
                                    <div class="pb-2">
                                        @if(!empty($record->category))
                                            <span class="badge badge-danger">{{$record->category}}</span>
                                        @endif
                                        <a href="{{route('staff.customer.detail',[$record->id])}}">{{$record->name}}</a>
                                        @if(!empty($record->dob) && $record->dob->format('m') == date('m'))
                                            <span class="fa fa-star text-gray" data-toggle="tooltip" title="Birthday This Month"></span>
                                        @endif
                                    </div>
                                    <a class="btn btn-success btn-xs" href="{{route('staff.customer.add_log',$record->id)}}" data-toggle="tooltip" title="Add Log"><i class="fa fa-plus"></i></a>&nbsp;
                                    <a class="btn btn-default btn-xs" href="{{route('staff.customer.edit',$record->id)}}" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>&nbsp;
                                </td>
                                <td>{{$record->tel}}</td>
                                <td>{{$record->gender}}</td>
                                <td>{{$record->city}}</td>
                                <td>{{$record->dob ? $record->dob->toFormattedDateString() : ' - '}}</td>
                                <td>{{$record->visit_count}}</td>
                                <td>{{empty($record->total_spent) ? '0' : ("RM ".number_format($record->total_spent))}}</td>
                                <td>{{$record->last_visit_at ? $record->last_visit_at->toFormattedDateString() : ' - '}}</td>
                                <td>{{$record->created_at ? $record->created_at->toFormattedDateString() : ' - '}}</td>
                                <td><small>{!! empty($record->remark) ? ' - ' : nl2br($record->remark) !!}</small></td>
                                <td>{{empty($record->stylist) ? ' - ' : $record->stylist_name}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{!empty($data) ? 'Total record : ' . number_format($data->toArray()['total']) : ''}}
                    <div class="pull-right">{{$data->appends($filterSelected)->links()}}</div>
                </div>
            </div>
        </section>
    </div>
@stop

@section('js')
    @include('admin.elements._js_daterange_filter')
    <script>
        $('#datatable').DataTable({
            "order": [[ 1, "desc" ]],
            "lengthChange": false,
            "searching": false,
            "paging": false,
            "pageLength": 50,
            "ordering": false,
            "info": false,
        });
    </script>
@stop
