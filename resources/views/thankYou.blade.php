@extends('layouts.front_simple')
@section('title') - Thank You @stop
@section('css')
    <style>
        .item {
            font-family: Rambla,sans-serif;
            font-size: .8125rem;
            line-height: 1.625rem;
            color: #919191;
            background-color: #f9f9f9;
            padding: 100px 20px;
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
                        <h2 align="center">Thank You</h2>
                        <p align="center">We hope to see you again.</p>


                        <br />
                        <div class="text-center">
                            <a class="btn btn-success" href="{{route('newCustomer')}}" style="color: #ffffff;">Back</a>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@stop