@extends('layouts.front')

@section('content')
    <div id="intro">
        <div class="logo"></div>
        <div class="loading">
            <div class="loader1"></div>
        </div>
    </div>

    <section id="hero" data-panel="hero">
        <div class="content imgLiquid">
            <div class="tagline">
                <h1>{{$system_info->head_line}}</h1>
                <h2>{{$system_info->slogan}}</h2>
                {{--<span class="subinfo">since 1994</span>--}}
            </div>
            <img src="{{asset($system_info->image_path)}}" alt="Welcome to {{$system_info->head_line}}">
        </div>
    </section>

    <header>
        <h1><a href="{{route('index')}}" title="{{$system_info->head_line}}"><img src="{{asset('images/logo.png')}}" alt="{{$system_info->head_line}}"></a></h1>
        <nav id="mainmenu" class="menu-horizontal">
            <ul>
                <li><a href="#about" data-panel="about">About Us</a></li>
                {{--<li><a href="#mastersvision" data-panel="mastersvision">The Masters Vision</a></li>--}}
                @if(count($team))
                <li><a href="#team" data-panel="team">Team</a></li>
                @endif
                @if(count($service))
                <li><a href="#services" data-panel="services">Services</a></li>
                @endif
                @if(count($gallery))
                <li><a href="#snapshots" data-panel="snapshots">Snap Shots</a></li>
                @endif
                @if(count($news))
                <li><a href="#news" data-panel="news">News</a></li>
                @endif
                <li><a href="#booking" data-panel="booking">Booking</a></li>
                <li><a href="#contact" data-panel="contact">Contact</a></li>
            </ul>
        </nav>

        <div id="socialshare">
            <a id="socialshare_trigger" class="icon-"></a>
            <nav class="animated">
                <ul>
                    <li><a href="https://www.instagram.com/alphstudio/" target="_blank">Instagram</a></li>
                    <li><a href="https://www.facebook.com/Alphstudioplus/" target="_blank">Facebook</a></li>
                </ul>
            </nav>
        </div>

    </header>

    <section id="about" data-panel="about" class="col-3 slider hl-text-slider">
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
                            <img src="{{$image}}" />
                        </div>
                    @endforeach
                    </div>
                @endif
            </div>
        </article>
    </section>

    <section id="mastersvision" data-panel="mastersvision" class="col-3 pic-hl-text">
        <article>
            <div class="pic">
                <img src="{{asset($system_info->vision_image_path)}}" alt="Master">
            </div><div class="hlblock">
                <h1>The masters vision</h1>
            </div><div class="content">
                {!! nl2br($system_info->about_us_desc) !!}
            </div>
        </article>
    </section>

    @if(count($team))
        <section id="team" data-panel="team" class="tophead mixitup supermix">
            <article><div class="hlblock controls">
                    <h1>Team</h1>
                    <div class="multilist">
                        <ul class="filterlist" data-label="Specialty: " data-default="All Specialty">
                            <li class="label"><a class="default">Specialty: </a></li>
                            <li><a class="filter" data-filter=".color-artist">Color Artist</a></li>
                            <li><a class="filter" data-filter=".make-overs">Make-Overs</a></li>
                            <li><a class="filter" data-filter=".evening-styles">Evening Styles</a></li>
                            <li><a class="filter" data-filter=".mens-styles">Men's Styles</a></li>
                            <li><a class="filter" data-filter=".extensions">Extensions</a></li>
                        </ul>
                        <ul class="filterlist" data-label="Available on: " data-default="Everyday">
                            <li class="label"><a class="default">Available on: </a></li>
                            <li><a class="filter" data-filter=".monday">Monday</a></li>
                            <li><a class="filter" data-filter=".tuesday">Tuesday</a></li>
                            <li><a class="filter" data-filter=".wednesday">Wednesday</a></li>
                            <li><a class="filter" data-filter=".thursday">Thursday</a></li>
                            <li><a class="filter" data-filter=".friday">Friday</a></li>
                            <li><a class="filter" data-filter=".saturday">Saturday</a></li>
                            <li><a class="filter" data-filter=".sunday">Sunday</a></li>
                        </ul>
                        <a class="reset">reset</a>

                    </div>
                </div>
                <div class="filteritems team">
                    @foreach($team as $count => $item)
                    {!! $count > 0 ? '-->' : '' !!}<div class="item {{str_replace(',',' ',$item->specialty)}} {{str_replace(',',' ',$item->availability)}}">
                        <div class="pic imgLiquidTopCenter"><img src="{{asset($item->avatar_path)}}" alt="{{$item->name}}"></div>
                        <div class="text">
                            <h3>{{$item->name}}</h3>
                            <span class="sub-info">Evening Styles</span>
                            <p>{{$item->description}}</p>
                            <a href="#booking" class="button">Book Appointment</a>
                        </div>
                    </div>{!! $count < (count($team) - 1) ? '<!--' : '' !!}
                    @endforeach
                </div>
                <div class="pagerlist dark"></div>
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
                </ul>
            </div>
            <div class="filteritems services">
                @foreach($service as $item)
                <div class="item {{$item->type}}">
                    <h3>{{$item->name}}</h3>
                    <p>{{$item->description}}</p><a href="#booking"><i>book now</i><span class="price">RM {{number_format($item->price)}}</span></a>
                </div>
                @endforeach
            </div><!--slickcarousel-->
            <div class="pagerlist dark"></div>
        </article>
    </section>
    @endif

    @if(count($gallery))
        <section id="snapshots" data-panel="snapshots" class="tophead polaroid">
            <article><div class="hlblock">
                    <h1>Client snap shots</h1>
                </div>
                <div class="polaroidgallery photostack hidebullets">
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
                    <li><a class="filter" data-filter=".cat-specials">Specials</a></li>
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
                    <h2>{{str_limit($item->title,49)}}</h2>
                    <p>{{$item->description}}</p>
                    <a class="more icon-salon_plus" href="{{route('news',['date'=>$item->news_date->toDateString(),'slug'=>$item->slug])}}">read more</a>
                </div>
                @endforeach
            </div><!--slickcarousel-->
            <div class="pagerlist dark"></div>
        </article>
    </section>
    @endif

    <section id="booking" data-panel="booking" class="col-2 default-left">
        <article><div class="hlblock">
                <h1>Request Appointment</h1>
                <p>
                    Please fill out the form on the right, <br/>and one of our staff will get back to you <br/>to discuss further details and confirm <br/>the appointment.
                </p>
            </div><div class="content">
                <form id="bookingform" method="POST" action="#" class="salonform">
                    <div class="columns-1-2">
                        <fieldset>
                            <label>Your Name</label>
                            <input type="text" name="name" placeholder="Your Name" data-validetta="required">
                        </fieldset>
                        <fieldset>
                            <label>Your Phone No.</label>
                            <input type="text" name="phone" placeholder="Your Phone No." data-validetta="required">
                        </fieldset>
                    </div><div class="columns-2-2">
                        <fieldset class="select">
                            <label>Stylist</label>
                            <select name="stylist" data-placeholder="Select your prefered Stylist">
                                <option value="lucy">Lucy</option>
                                <option value="adam">Adam</option>
                                <option value="josh">Josh</option>
                                <option value="valerie">Valerie</option>
                            </select>
                        </fieldset>
                        <fieldset class="select">
                            <label>Service(s)</label>
                            <select name="service[]" multiple data-placeholder="Select your desired Service(s)">
                                <optgroup label="Basic">
                                    <option value="cut-style">Cut & Style</option>
                                    <option value="quick-cut">Quick Cut</option>
                                    <option value="wash-go">Wash & Go</option>
                                    <option value="evening-style">Evening Style</option>
                                </optgroup>
                                <optgroup label="Color">
                                    <option value="coloration">Coloration</option>
                                    <option value="hightlights-lowlights">Highlights & Lowlights</option>
                                    <option value="hightlights">Highlights</option>
                                    <option value="balayage">Balayage</option>
                                </optgroup>
                            </select>
                        </fieldset>
                        <fieldset class="select">
                            <label>Date/Time</label>
                            <input type="text" name="datetime" class="datetime" data-validetta="required">
                        </fieldset>
                    </div>
                    <fieldset class="submit">
                        <input type="hidden" name="subject" value="Booking request from the website">
                        <input type="hidden" name="formtype" value="bookingform">
                        <input type="submit" name="submit" value="Submit">
                    </fieldset>
                    <div class="status">Message successfully sent, thank you!</div>
                </form>
            </div>
        </article>
    </section>

    <section id="contact" data-panel="contact" class="col-3 stripes stripes-1">
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
                    <p><strong>Address</strong><br/>
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
                <form class="inverted salonform" id="contactform" method="POST" action="#">
                    <fieldset>
                        <label>Your Name</label>
                        <input type="text" name="name" placeholder="Your Name" data-validetta="required">
                    </fieldset>
                    <fieldset>
                        <label>Your E-Mail</label>
                        <input type="text" name="email" placeholder="Your Email" data-validetta="required,email">
                    </fieldset>
                    <fieldset>
                        <label>Your Message</label>
                        <textarea class="autosize" name="message" placeholder="Your Message" data-validetta="required"></textarea>
                    </fieldset>
                    <fieldset class="submit left">
                        <input type="hidden" name="subject" value="Contact from the website">
                        <input type="hidden" name="formtype" value="contactform">
                        <input type="submit" name="submit" value="Submit">
                    </fieldset>
                    <div class="status">Message successfully sent, thank you!</div>
                </form>
            </div>
        </article>

    </section>

    <section id="map" data-panel="map" class="tophead maps">
        <article>
            <div class="hlblock">
                <h1>Where to find us</h1>
                <div class="filterlist maplist" data-label="Filter: " data-default="All"></div>
            </div><div class="gmap">

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