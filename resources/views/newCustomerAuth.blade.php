@extends('layouts.front_simple')
@section('title') - Pass code @stop
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
                        <h2 align="center">Enter passcode to create new customer.</h2>
                        <form method="POST">
                            @csrf

                            <div class="form-group row">
                                <div class="offset-lg-4 col-lg-4">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="offset-lg-4 col-lg-4">
                                    <button type="submit" class="btn btn-success btn-block">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
@stop