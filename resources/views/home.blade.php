@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if(!empty($birthday_customer))
                            <div class="jumbotron" style="padding: 2rem 2rem;">
                                <h1>Birthday Reminder</h1>
                                <p>There is <b>{{$birthday_customer}}</b> customer(s) birthday this month.</p>
                                <p>
                                    <a class="btn btn-primary btn-lg"
                                       href="{{route('staff.customer',['type'=>'birthday'])}}" role="button">
                                        Check it out
                                    </a>
                                </p>
                            </div>
                        @endif

                        @if($sms_balance != 'X' && $sms_balance < 200)
                            <div class="jumbotron" style="padding: 2rem 2rem;background-color: #eec4cd">
                                <h1>Running out of SMS quota</h1>
                                <p>You've remaining SMS quota <b>{{$sms_balance}}</b>, please contact your tech support for topup.</p>
                            </div>
                        @endif

                        @include('flash::message')
                        @include('error_list')

                        <h3>System Information</h3>
                        {{ Form::model($record,['class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) }}
                        <div class="form-group row">
                            {{ Form::label('address', 'Address', ['class'=>'col-form-label col-sm-2']) }}
                            <div class="col-sm-10">
                                {{ Form::textarea('address', old('address'), ['class'=>'form-control', 'required','rows'=>'3']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('contact_number', 'Contact No.', ['class'=>'col-form-label col-sm-2']) }}
                            <div class="col-sm-10">
                                {{ Form::tel('contact_number', old('contact_number'), ['class'=>'form-control']) }}
                                <small>Use a comma (,) to add additional contact number.</small>
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('fax_number', 'Fax No.', ['class'=>'col-form-label col-sm-2']) }}
                            <div class="col-sm-10">
                                {{ Form::tel('fax_number', old('fax_number'), ['class'=>'form-control','placeholder'=>'optional']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('email', 'Email', ['class'=>'col-form-label col-sm-2']) }}
                            <div class="col-sm-10">
                                {{ Form::email('email', old('email'), ['class'=>'form-control','placeholder'=>'optional']) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{ Form::label('head_line', 'Head Line', ['class'=>'col-form-label col-sm-2']) }}
                            <div class="col-sm-10">
                                {{ Form::text('head_line', old('head_line'), ['class'=>'form-control','required']) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{ Form::label('slogan', 'Slogan', ['class'=>'col-form-label col-sm-2']) }}
                            <div class="col-sm-10">
                                {{ Form::text('slogan', old('slogan'), ['class'=>'form-control','required']) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{ Form::label('promo_link', 'Promo Link', ['class'=>'col-form-label col-sm-2']) }}
                            <div class="col-sm-10">
                                {{ Form::url('promo_link', old('promo_link'), ['class'=>'form-control','placeholder'=>'optional']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('image', 'Cover Image (1600 x 1067)', ['class'=>'col-form-label col-sm-2']) }}
                            <div class="col-sm-10">
                                {{ Form::file('image', ['class'=>'form-control']) }}
                                @if(!is_null($record->image_path))
                                    <br /><img src="{{asset($record->image_path)}}" width="150px"/>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('hover_image', 'Cover Hover Image (1600 x 1067)', ['class'=>'col-form-label col-sm-2']) }}
                            <div class="col-sm-10">
                                {{ Form::file('hover_image', ['class'=>'form-control']) }}
                                @if(!is_null($record->hover_image_path))
                                    <br /><img src="{{asset($record->hover_image_path)}}" width="150px"/>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('about_us_desc', 'About Us Description', ['class'=>'col-form-label col-sm-2']) }}
                            <div class="col-sm-10">
                                {{ Form::textarea('about_us_desc', old('about_us_desc'), ['class'=>'form-control','rows'=>'5']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('vision_desc', 'Vision Description', ['class'=>'col-form-label col-sm-2']) }}
                            <div class="col-sm-10">
                                {{ Form::textarea('vision_desc', old('vision_desc'), ['class'=>'form-control','rows'=>'5']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                {{ Form::submit('Edit Website Info', ['class'=>'btn btn-primary btn-block']) }}
                            </div>
                        </div>

                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
