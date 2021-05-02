@if(!empty($page_title))
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        {{$page_title}}
                        @if(!empty($add_link))
                            <a href="{{$add_link}}" class="btn btn-tool btn-success text-success"><i class="fa fa-plus"></i> Add New</a>
                        @endif
                    </h1>
                    @if(!empty($last_modify))
                        <div class="text-gray"><i>Last modified @ <b>{{$last_modify}}</b> {{empty($modify_by) ? "" : " by $modify_by"}}</i></div>
                    @endif
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @if(\Illuminate\Support\Facades\Route::currentRouteName() != 'staff.home')
                            <li class="breadcrumb-item"><a href="{{route('staff.home')}}">Dashboard</a></li>
                        @endif
                        @if(!empty($breadcrumb))
                            @foreach($breadcrumb as $name => $url)
                                <li class="breadcrumb-item"><a href="{!! $url !!}">{{$name}}</a></li>
                            @endforeach
                        @endif
                        <li class="breadcrumb-item active">{{$page_title}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
@else
    <br />
@endif
