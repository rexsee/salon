@extends('layouts.front')

@section('content')
    @include('flash::message')
    <div style="text-align: center">
        <a href="{{route('index')}}"><img src="{{asset('images/logo.png')}}" width="120px"></a>
    </div>

    <section class="tophead mixitup supermix" style="padding-top: .5rem">
        <article>
            <div class="content">
                <div class="news">
                    <div class="item">
                        <div class="meta">
                            <a class="category">{{ucfirst($news->type)}}</a> <i>/</i> <span class="date">{{$news->news_date->toFormattedDateString()}}</span>
                        </div>
                        <h2 style="margin-top: 0">{{$news->title}}</h2>
                        <p>{!! nl2br($news->content) !!}</p>

                        <br />
                        <div style="text-align: center;">
                            <a style="font-size: 14pt;text-decoration: underline" href="{{route('index')}}">Back</a>
                        </div>

                    </div>
                </div>
            </div>
        </article>
    </section>

    <section id="end">
        <div class="content">
            <div class="copyright">
                <img src="{{asset('images/logo-small.png')}}" alt="{{env('APP_NAME')}}">
                <p>Copyright {{env('APP_NAME')}} - All rights reserved</p>
            </div>
        </div>
        <a id="back2top" class="backtotop icon-salon_arrowup">back to top</a>
    </section>
@stop