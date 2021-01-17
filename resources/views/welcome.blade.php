@extends('layouts.front')
@section('title') - {{$system_info->slogan}}@stop
@section('css')
    <style>
        #cover_img_container{
            background: url('{{$system_info->image_path}}');
            background-size:cover;
            background-repeat:   no-repeat;
            background-position: center center;
            transition: .8s;
        }
    </style>
    @if(!empty($system_info->hover_image_path))
        <style>
            #cover_img_container:hover{
                background: url('{{$system_info->hover_image_path}}');
                background-size:cover;
                background-repeat:   no-repeat;
                background-position: center center;
                transition: .8s;
            }
        </style>
    @endif
@stop
@section('content')
    @if(env('APP_ENV') == 'production')
    <div id="intro">
        <div class="logo"></div>
        <div class="loading">
            <div class="loader1"></div>
        </div>
    </div>
    @endif

    <section id="hero" data-panel="hero">
        <div id="cover_img_container" class="content imgLiquid">
            <div class="tagline">
                <h1>{{$system_info->head_line}}</h1>
                <h2>{{$system_info->slogan}}</h2>
            </div>
        </div>
    </section>

    <header>
        <h1><a href="{{route('index')}}" title="{{$system_info->head_line}}"><img src="{{asset('images/logo.png')}}" alt="{{$system_info->head_line}}"></a></h1>
        <nav id="mainmenu" class="menu-horizontal">
            <ul>
                <li><a href="#about" data-panel="about">About Us</a></li>
                @if(count($team))
                <li><a href="#team" data-panel="team">Team</a></li>
                @endif
                @if(count($service))
                <li><a href="#services" data-panel="services">Services</a></li>
                @endif
                @if(count($product))
                <li><a href="#product" data-panel="product">Products</a></li>
                @endif
                @if(count($artwork))
                <li><a href="#brands" data-panel="brands">Artwork</a></li>
                @endif
                @if(count($gallery))
                <li><a href="#snapshots" data-panel="snapshots">Snap Shots</a></li>
                @endif
                @if(count($news))
                <li><a href="#news" data-panel="news">News</a></li>
                @endif
                {{--<li><a href="#booking" data-panel="booking">Booking</a></li>--}}
                <li><a href="#contact" data-panel="contact">Contact</a></li>
            </ul>
        </nav>

        <div id="socialshare">
            @if(!empty($system_info->promo_link))
                <a class="socialicon socialicon-promo blink_me" href="{{$system_info->promo_link}}" target="_blank"><img src="{{asset('images/promo2.png')}}" /> </a>
            @endif
            <a class="socialicon socialicon-insta" href="https://www.instagram.com/alphstudio/" target="_blank"><img src="{{asset('images/insta.png')}}" /> </a>
            <a class="socialicon socialicon-fb" href="https://www.facebook.com/Alphstudioplus/" target="_blank"><img src="{{asset('images/fb.png')}}" /></a>
            {{--<a id="socialshare_trigger" class="icon-" target="_blank"></a>--}}
            {{--<nav class="animated">--}}
                {{--<ul>--}}
                    {{--<li><a href="https://www.instagram.com/alphstudio/" target="_blank">Instagram</a></li>--}}
                    {{--<li><a href="https://www.facebook.com/Alphstudioplus/" target="_blank">Facebook</a></li>--}}
                {{--</ul>--}}
            {{--</nav>--}}
        </div>

    </header>

    <section id="about" data-panel="about" class="colx-3 slider hl-text-slider">
        <article>
            <div class="hlblock">
                <h1>About the salon</h1>
            </div><div class="content">
                {!! nl2br($system_info->about_us_desc) !!}
            </div>
            <div class="sliderwrapper slickexpandable">
                @if(!empty($slider_images))
                    <div class="slick">
                    @foreach($slider_images as $image)
                        <div class="slide imgLiquid">
                            <img src="{{$image->image_path}}" alt="{{$image->title}}" />
                        </div>
                    @endforeach
                    </div>
                @endif
            </div>
        </article>
    </section>

    <section id="mastersvision" data-panel="mastersvision" class="colx-3 slider hl-text-slider">
        <article>
            <div class="hlblock display-mobile">
                <h1>The Master Vision</h1>
            </div>
            <div class="sliderwrapper slickexpandable">
                @if(!empty($vision_images))
                    <div class="slick">
                        @foreach($vision_images as $image)
                            <div class="slide imgLiquid">
                                <img src="{{$image->image_path}}" alt="{{$image->title}}" />
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="content" style="background-color: #f9f9f9">
                {!! nl2br($system_info->vision_desc) !!}
            </div><div class="hlblock display-desktop">
                <h1>The Master Vision</h1>
            </div>
        </article>
    </section>

    @if(count($team))
        <section id="team" data-panel="team" class="tophead mixitup simplemix">
            <article><div class="hlblock controls">
                    <h1>Team</h1>
                </div>
                <div class="filteritems team">
                    @foreach($team as $count => $item)
                    {!! $count > 0 ? '-->' : '' !!}<div class="item {{str_replace(',',' ',$item->specialty)}} {{str_replace(',',' ',$item->availability)}}">
                        <div class="pic imgLiquidTopCenter" style="filter:none"><img src="{{asset($item->avatar_path)}}" alt="{{$item->name}}"></div>
                        <div class="text">
                            <h3>{{$item->name}}</h3>
                            <span class="sub-info">{{$item->title}}</span>
                            {{--<p>{{$item->description}}</p>--}}
                            {{--<a href="#booking" class="button">Book Appointment</a>--}}
                        </div>
                    </div>{!! $count < (count($team) - 1) ? '<!--' : '' !!}
                    @endforeach
                </div>
                <div class="pagerlist dark" style="bottom: -10px;"></div>
            </article>
        </section>
    @endif

    @if(count($service))
    <section id="services" data-panel="services" class="tophead mixitup sixmix">
        <article><div class="hlblock">
                <h1>Services</h1>
                <ul class="filterlist" data-label="Filter: " data-default="All">
                    <li><a class="filter active" data-filter="all">All</a></li>
                    <li><a class="filter" data-filter=".cat-basics">Basics</a></li>
                    <li><a class="filter" data-filter=".cat-color">Color</a></li>
                    <li><a class="filter" data-filter=".cat-texturize">Texturize</a></li>
                    <li><a class="filter" data-filter=".cat-treatments">Treatments</a></li>
                </ul>
            </div>
            <div class="filteritems services">
                @foreach($service as $item)
                <div class="item {{$item['type']}}" data-mh="same-height-group-1">
                    <h3>{{$item['name']}}</h3>
                    {{--<p>{{$item->description}}</p><a href="#booking"><i>book now</i><span class="price">RM {{number_format($item->price)}} ++</span></a>--}}
                    @foreach($item['data'] as $desc)
                        <p>{{$desc['description']}}</p><a><span class="price">{{$desc['price']}}</span></a>
                    @endforeach
                </div>
                @endforeach
            </div><!--slickcarousel-->
            <div class="services-note"><i>* additional charges applicable if by director</i></div>
            <div class="pagerlist dark"></div>
        </article>
    </section>
    @endif

    @if(count($product))
        <section id="product" data-panel="product" class="tophead mixitup simplemix">
            <article>
                <div class="hlblock">
                    <h1>Products</h1>
                    <ul class="filterlist" data-label="Filter: " data-default="All">
                        <li><a class="filter active" data-filter="all">All</a></li>
                        @foreach(getProductCollections() as $pk => $pv)
                            <li><a class="filter" data-filter=".cat-{{$pk}}">{{$pv}}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="filteritems news">
                    @foreach($product as $item)
                        <div class="item cat-{{$item->collection}}">
                            <h2 style="margin-top: 0;margin-bottom: 0;font-size: 1.2rem;line-height: 1.2rem;height: 45px;">{{$item->name}}</h2>
                            <div class="meta" style="line-height: 0;margin-bottom: 10px">
                                <a class="category">RM {{number_format($item->price,2)}}</a>
                                @if(!empty($item->size))
                                    <i>/</i><span class="date">{{$item->size}}</span>
                                @endif
                            </div>
                            <p style="margin: 0"><a class="product-detail" data-productid="{{$item->id}}" href="javascript:void(0)"><img src="{{asset($item->image_path)}}" width="100%" /></a></p>
                            <div style="text-align: right">
                                <a class="more icon-salon_plus product-detail" data-productid="{{$item->id}}" href="javascript:void(0)">view detail</a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="pagerlist dark"></div>
            </article>
        </section>
    @endif

    @if(count($artwork))
    <section id="brands" data-panel="brands" class="colx-2 grid grid-right">
        <article>
            <div class="content slick">
                @foreach($artwork->chunk(16) as $artwork_slide)
                    <div class="slide">
                        <ul class="grid4x4">
                            @foreach($artwork_slide as $item)
                                <li class="artwork_image" data-title="{{$item->title}}" data-imgurl="{{$item->image_path}}">
                                    <img src="{{$item->image_path}}" alt="{{$item->title}}" />
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div><div class="hlblock">
                <h1>Artwork</h1>
            </div>
        </article>
    </section>
    @endif

    @if(count($gallery))
        <section id="snapshots" data-panel="snapshots" class="tophead polaroid">
            <article><div class="hlblock">
                    <h1>Snap shots</h1>
                </div>
                <div class="polaroidgallery photostack hidebullets" style="background-color: #f8f8f9">
                    <div>
                        @foreach($gallery as $item)
                            <figure>
                                <a class="photostack-img imgLiquid"><img src="{{asset($item->image_path)}}" alt="{{$item->title}}"/></a>
                                <figcaption>
                                    <h2 class="photostack-title">{{$item->title}}</h2>
                                    <div class="photostack-back">
                                        <p>{{$item->description}}</p>
                                    </div>
                                </figcaption>
                            </figure>
                        @endforeach
                    </div>
                </div><!--polaroidgallery-->
            </article>
        </section>
    @endif

    @if(count($news))
    <section id="news" data-panel="news" class="tophead mixitup simplemix">
        <article><div class="hlblock">
                <h1>News</h1>
                <ul class="filterlist" data-label="Filter: " data-default="All">
                    <li><a class="filter active" data-filter="all">All</a></li>
                    {{--<li><a class="filter" data-filter=".cat-specials">Specials</a></li>--}}
                    <li><a class="filter" data-filter=".cat-news">News</a></li>
                    <li><a class="filter" data-filter=".cat-events">Events</a></li>
                </ul>
            </div>
            <div class="filteritems news">
                @foreach($news as $item)
                <div class="item cat-{{$item->type}}">
                    <div class="meta">
                        <a class="category">{{ucfirst($item->type)}}</a><i>/</i><span class="date">{{$item->news_date->toFormattedDateString()}}</span>
                    </div>
                    <h2>{{str_limit($item->title,40)}}</h2>
                    <p><a href="{{route('news',['date'=>$item->news_date->toDateString(),'slug'=>$item->slug, 'ib'=>1])}}"><img src="{{asset($item->image_path)}}" width="100%" /></a></p>
                    <a class="more icon-salon_plus" href="{{route('news',['date'=>$item->news_date->toDateString(),'slug'=>$item->slug, 'ib'=>1])}}">read more</a>
                </div>
                @endforeach
            </div><!--slickcarousel-->
            <div class="pagerlist dark"></div>
        </article>
    </section>
    @endif

    <!--
    <section id="booking" data-panel="booking" class="colx-2 default-left">
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
                            {{ Form::text('name', array_get($_COOKIE,'customer_name'), ['data-validetta'=>'required','placeholder'=>'Your Name']) }}
                        </fieldset>
                        <fieldset>
                            {{ Form::label('phone', 'Your Phone No.') }}
                            {{ Form::text('phone', array_get($_COOKIE,'customer_phone'), ['data-validetta'=>'required','placeholder'=>'Your Phone No.']) }}
                        </fieldset>
                    </div><div class="columns-2-2">
                        <fieldset class="select">
                            {{ Form::label('stylist', 'Stylist') }}
                            {{ Form::select('stylist', $team->pluck('name','id')->toArray(), array_get($_COOKIE,'customer_stylist_id'), ['data-placeholder'=>'Select your prefered Stylist','id'=>'bookingformstylist']) }}
                        </fieldset>
                        <fieldset class="select">
                            {{ Form::label('service', 'Service(s)') }}
                            {{ Form::select('service[]', $serviceList, null, ['data-placeholder'=>'Select your desired Service(s)','multiple']) }}
                        </fieldset>
                        <fieldset class="select">
                            {{ Form::label('datetime', 'Date/Time') }}
                            {{ Form::text('datetime', null, ['data-validetta'=>'required','id'=>'datetimed']) }}
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
    -->

    <section id="contact" data-panel="contact" class="colx-3 stripes stripes-1">
        <article>
            <div class="hlblock">
                <h2>Opening hours</h2>
                <p><strong>Wednesday - Monday</strong><br/>
                    1030 AM - 2000 PM
                </p>
                <p><strong>Tuesday</strong><br/>
                    closed
                </p>
            </div><div class="content">
                <h2>Business Details</h2>
                @if(!empty($system_info->address))
                <p><strong>Address</strong><br/>
                    {!! nl2br($system_info->address) !!}
                </p>
                @endif
                @if(!empty($tels))
                    <p><strong>Tel.</strong><br/>
                        @foreach($tels as $tel)
                            {{$tel}}<br />
                        @endforeach
                    </p>
                @endif
                <p>
                    @if(!empty($system_info->email))
                        Email: <a href="mailto:{{$system_info->email}}">{{$system_info->email}}</a> <br />
                    @endif
                    @if(!empty($system_info->fax_number))
                        Fax: {{$system_info->fax_number}}<br/>
                    @endif
                </p>
            </div><div class="hlblock">
                <h2><span>Get in</span><span>Touch</span></h2>
                {{ Form::open(['class' => 'inverted salonform', 'id' => 'contactform']) }}
                    <fieldset>
                        {{ Form::label('name', 'Your Name') }}
                        {{ Form::text('name', null, ['data-validetta'=>'required','placeholder'=>'Your Name']) }}
                    </fieldset>
                    <fieldset>
                        {{ Form::label('email', 'Your Email') }}
                        {{ Form::email('email', null, ['data-validetta'=>'required,email','placeholder'=>'Your Email']) }}
                    </fieldset>
                    <fieldset>
                        {{ Form::label('phone', 'Your Phone No.') }}
                        {{ Form::text('phone', null, ['data-validetta'=>'required,tel','placeholder'=>'Your Phone No.']) }}
                    </fieldset>
                    <fieldset>
                        {{ Form::label('message_c', 'Your Message') }}
                        {{ Form::textarea('message_c', null, ['class'=>'autosize','data-validetta'=>'required','placeholder'=>'Your Message']) }}
                    </fieldset>
                    <fieldset class="submit left">
                        {{ Form::hidden('type','contact') }}
                        {{ Form::submit('Submit') }}
                    </fieldset>
                    <div class="status">Message successfully sent, thank you!</div>
                    <div class="status-error"></div>
                {{ Form::close() }}
            </div>
        </article>

    </section>

    <section id="map" data-panel="map" class="tophead maps">
        <article>
            <div class="hlblock">
                <h1>Where to find us</h1>
            </div><div class="gmap">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2105.518141996404!2d101.67414209681317!3d3.1256151888879247!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc4990e088c9b5%3A0xe29d4d272cfdff3!2sNadi+Bangsar!5e0!3m2!1sen!2smy!4v1536904103650" width="100%" height="100%" frameborder="0" style="border:0"></iframe>
            </div>
        </article>
    </section>

    <div id="productDetailModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5"><img id="pdetail-img" src="" style="width: 100%"></div>
                        <div class="col-md-7">
                            <small id="pdetail-category" style="background: #000;color: #fff;padding: 1px 10px;border-radius: 3px;"></small>
                            <h5 id="pdetail-name" class="mt-2 mb-0" style="line-height: 1rem;"></h5>
                            <small id="pdetail-price" style="display: block;color:#999;padding-bottom: 10px;font-weight: bold;"></small>
                            <p id="pdetail-description" style="line-height: 1.25em"></p>
                            <hr />
                            <b>Product Inquiry</b>
                            <div class="product-inquiry-box">
                                <a target="_blank" id="productInquiryWhatsapp" href="" style="display: inline-block;margin-right: 10px;margin-top: 10px;background: #25D366;border-radius: 50%;height: 50px;font-size: 30px;width: 50px;text-align: center;padding-top: 3px;color: #fff;"><i class="fa fa-whatsapp"></i></a> &nbsp;
                                <a target="_blank" id="productInquiryEmail" href="" style="display: inline-block;margin-right: 10px;margin-top: 10px;background: #000;border-radius: 50%;height: 50px;font-size: 25px;width: 50px;text-align: center;padding-top: 6px;color: #fff;position: relative;top: -3px;"><i class="fa fa-envelope"></i></a> &nbsp;
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="justify-content: center;">
                    <button type="button" class="btn btn-link btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @include('footer')
@stop

@section('js')
    <script>
        $('#datetimed').datetimepicker({
            theme: "dark",
            step: 30,
            minTime: "10:30",
            maxTime: "20:00",
            allowTimes:['10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30']
        });
        $('#datetimed').datetimepicker('reset');

        @if(count($artwork))
        $('.artwork_image').on('click', function () {
            tt = $(this).attr('data-title');
            imgurl = $(this).attr('data-imgurl');
            $.confirm({
                title: tt,
                content: '<img src="'+imgurl+'">',
                animation: 'scale',
                animationClose: 'top',
                escapeKey: true,
                backgroundDismiss: true,
                buttons: {
                    cancel: function () {
                        // lets the user close the modal.
                    }
                }
            });
        });
        @endif

        $("body").on("click", "a.product-detail", function () {
            var productid = $(this).data('productid');
            var pdetail_img = $('#pdetail-img');
            var pdetail_name = $('#pdetail-name');
            var pdetail_category = $('#pdetail-category');
            var pdetail_price = $('#pdetail-price');
            var pdetail_whatsapp = $('#productInquiryWhatsapp');
            var pdetail_email = $('#productInquiryEmail');
            var pdetail_description = $('#pdetail-description');

            pdetail_name.html('');
            pdetail_category.html('');
            pdetail_price.html('');
            pdetail_description.html('');
            pdetail_img.attr("src", "");
            pdetail_whatsapp.attr("href", "");
            pdetail_email.attr("href", "");

            $.ajax({
                url: "{{route('productDetail')}}?id=" + productid,
                success: function (data) {
                    pdetail_name.html(data.name);
                    pdetail_category.html(data.collection);
                    pdetail_price.html(data.price);
                    pdetail_description.html(data.description);
                    pdetail_img.attr("src", data.image_path);
                    pdetail_whatsapp.attr("href", data.whatsapp_link);
                    pdetail_email.attr("href", data.mail_link);
                }
            });

            $('#productDetailModal').modal();
        });
    </script>
@stop
