@extends('layouts.front_simple')
@section('title') - {{$news->title}} @stop
@section('css')
    <style>
        .item {
            font-family: Rambla,sans-serif;
            font-size: .8125rem;
            line-height: 1.625rem;
            color: #919191;
            background-color: #f9f9f9;
            padding: 20px;
        }
        
        .item .category{
            color: #555555;
        }

        .item h2{
            font-family: Poiret One,sans-serif;
            text-transform: uppercase;
            font-weight: 400;
            margin-top: 0;
            margin-bottom: 1em;
            line-height: 120%;
        }

        .item img{
            max-width: 400px;
            padding-bottom: 10px;
        }
    </style>
@stop

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="text-center">
                    <a href="{{route('index')}}"><img src="{{asset('images/logo.png')}}" width="120px"></a>
                </div>

                    <div class="item">
                        <span class="category">{{ucfirst($news->type)}}</span> <i>/</i> {{$news->news_date->toFormattedDateString()}}
                        <h2>{{$news->title}}</h2>
                        <div class="text-center">
                            <img src="{{asset($news->image_path)}}" alt="{{$news->title}}"/>
                        </div>
                        <p>{!! nl2br($news->content) !!}</p>

                        <br />
                        @if(!empty($is_back))
                        <div class="text-center">
                            <a style="font-size: 14pt;text-decoration: underline;cursor: pointer" onclick="history.back()">Back</a>
                        </div>
                        @endif
                    </div>
            </div>
        </div>
    </div>
@stop