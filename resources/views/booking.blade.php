@extends('layouts.front')
@section('title') - Booking @stop
@section('css')
    @if(!empty($suggest_time))
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
        <style>
            .jconfirm-box-container{
                width:90%;
                margin: 0 auto;
            }
        </style>
    @endif
@stop

@section('content')
    <div style="text-align: center">
        <a href="{{route('index')}}"><img src="{{asset('images/logo.png')}}" width="120px"></a>
    </div>

    <section id="booking" data-panel="booking" class="col-2 default-left" style="padding-top: .5rem;height: 90%">
        <article><div class="hlblock">
                <h1>Request Appointment</h1>
                <p>
                    Please fill out the form, <br />your booking will be reserve for <br />15 minutes after the booking time. <br />Please call us if you need modify your booking detail.
                </p>
            </div><div class="content">
                {{ Form::open(['class' => 'salonform', 'id' => 'bookingform']) }}
                    <div class="columns-1-2">
                        <fieldset>
                            {{ Form::label('name', 'Your Name') }}
                            {{ Form::text('name', $name, ['data-validetta'=>'required','placeholder'=>'Your Name']) }}
                        </fieldset>
                        <fieldset>
                            {{ Form::label('phone', 'Your Phone No.') }}
                            {{ Form::text('phone', $tel, ['data-validetta'=>'required','placeholder'=>'Your Phone No.']) }}
                        </fieldset>
                    </div><div class="columns-2-2">
                        <fieldset class="select">
                            {{ Form::label('stylist', 'Stylist') }}
                            {{ Form::select('stylist', $team->pluck('name','id')->toArray(), $stylist_id, ['data-placeholder'=>'Select your prefered Stylist']) }}
                        </fieldset>
                        <fieldset class="select">
                            {{ Form::label('service', 'Service(s)') }}
                            {{ Form::select('service[]', $serviceList, explode(',',$services_id), ['data-placeholder'=>'Select your desired Service(s)','multiple']) }}
                        </fieldset>
                        <fieldset class="select">
                            {{ Form::label('datetime', 'Date/Time') }}
                            {{ Form::text('datetime', $date, ['data-validetta'=>'required','id'=>'datetimed']) }}
                        </fieldset>
                    </div>
                    <fieldset class="submit">
                        {{ Form::hidden('type','booking') }}
                        {{ Form::submit('Submit') }}
                    </fieldset>
                    <div class="status">Your booking is confirmed, thank you. See you soon ;)</div>
                    <div class="status-error"></div>
                {{ Form::close() }}
            </div>
        </article>
    </section>

    @include('footer')
@stop

@section('js')
    @if(!empty($suggest_time))
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
        <script>
            $.alert({
                title: 'Ops, the booking date was taken!',
                content: '{{$suggest_time}}'
            });

            $('#datetimed').datetimepicker({
                theme: "dark",
                step: 30,
                minTime: "10:30",
                maxTime: "20:00",
                allowTimes:['10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30']
            });
            $('#datetimed').val('{{$date}}');
            $('#datetimed').datetimepicker('reset')
        </script>
    @endif
@stop
