<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <?php use Illuminate\Support\Facades\Route;
    $currentRout = Route::getFacadeRoot()->current()->uri();
    ?>
    <!-- Global Site Tag (gtag.js) - Google Analytics -->
    {{--<script async src="https://www.googletagmanager.com/gtag/js?id=UA-105149828-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments)};
      gtag('js', new Date());

      gtag('config', 'UA-105149828-1');
    </script>--}}
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-NDN3DQ7');
    </script>
    <!-- End Google Tag Manager -->
    <meta charset="UTF-8">
    {!! SEO::generate(true) !!}
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">

    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="icon"
          type="image/png"
          href="{{asset('img/favicon.ico')}}">
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/index.css?v=1.2.6') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-rtl.css?v=1.2') }}">
    <link type="text/css" href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet"/>

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bookmarks.css?v=0.0.3') }}">
    <link type="text/css" href="{{ asset('css/flickity.min.css') }}" rel="stylesheet"/>


    <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
    <script async src="{{ asset('js/bootstrap.js') }}" type="text/javascript"></script>
    <script async src="{{ asset('js/translation.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/all.js?v=1.7') }}" type="text/javascript"></script>
    <script async src="{{ asset('js/jquery.twbsPagination.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('js/new_landing.js?v=1.2.9') }}"></script>

    <link type="text/css" href="{{ asset('css/slick.css') }}" rel="stylesheet"/>
    <link type="text/css" href="{{ asset('css/slick-theme.css') }}" rel="stylesheet"/>
    <script src="{{ URL::asset('js/slick.min.js') }}"></script>
    <link type="text/css" href="{{ asset('css/search_new.css?v=1.1.3') }}" rel="stylesheet">

    <script type="text/javascript">
        jQuery.browser = {};
        (function () {
            jQuery.browser.msie = false;
            jQuery.browser.version = 0;
            if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
                jQuery.browser.msie = true;
                jQuery.browser.version = RegExp.$1;
            }
        })();
    </script>
    <script type="text/javascript">
        window.smartlook || (function (d) {
            var o = smartlook = function () {
                o.api.push(arguments)
            }, h = d.getElementsByTagName('head')[0];
            var c = d.createElement('script');
            o.api = new Array();
            c.async = true;
            c.type = 'text/javascript';
            c.charset = 'utf-8';
            c.src = 'https://rec.getsmartlook.com/recorder.js';
            h.appendChild(c);
        })(document);
        smartlook('init', 'd77a149643e0bb36360c00abbc07539afb87a036');
    </script>

    <style>
        @media only screen and (max-width: 640px) {
            #lhc_need_help_container {
                display: none !important;
            }

            #lhc_status_container {
                display: none !important;
            }
        }

        input[type="text"]:-moz-placeholder {
            text-align: right;
        }

        input[type="text"]:-ms-input-placeholder {
            text-align: right;
        }

        input[type="text"]::-webkit-input-placeholder {
            text-align: right;
        }
    </style>

</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NDN3DQ7"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <script type="application/ld+json">
      {
        "@context": "http://schema.org",
        "@type": "Organization",
        "name": "Shab",
        "url": "https://www.shab.ir",
		"logo": "https://www.shab.ir/img/logo.png",
		"contactPoint": [{
			"@type": "ContactPoint",
			"telephone": "+98-21-2239-8202",
			"contactType": "customer service"
		}],
        "sameAs": [
          "https://facebook.com/shabDOTir",
          "https://plus.google.com/109089824001381609228",
          "https://www.linkedin.com/company/shab.ir",
          "https://instagram.com/_shab.ir",
          "https://aparat.com/shab.ir"
        ]
      }
	</script>
	<script type="application/ld+json">
      {
        "@context": "http://schema.org",
        "@type": "Blog",
        "url": "https://www.shab.ir/blog"
      }
	</script>
	<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@type": "WebSite",
		"url": "https://www.shab.ir/",
		"potentialAction": {
		"@type": "SearchAction",
		"target": "https://www.shab.ir/search?destination={search_term_string}",
		"query-input": "required name=search_term_string"
		}
	}
	</script>
{{-- @include('Analyticsicstracking') --}}
<header>

    @include('signinup')

    <nav class="shab-navbar">
        {{--
        <script>
            $(document).ready(function(){
                if($( window ).width() <= 500)
                    $("#voteLink").attr("href", "tel:*3*33*21264 %23");
                $(window).resize(function(){
                    if($( window ).width() <= 500)
                        $("#voteLink").attr("href", "tel:*3*33*21264 %23");
                });
            });
        </script>
        --}}
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header" style="float: none !important;">
                <button type="button" class="navbar-toggle collapsed" toggle=false>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <h1>
                    <a class="navbar-brand" href="#">شب‌، اجاره ویلا</a>
                </h1
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="shab-nav">
                <ul class="nav navbar-nav">
                    <li class="active become_host" >
                        <a @if (Auth::guest()) data-toggle="modal" data-target="#login-modal" onclick="redirectToBehHost()"  @else href="{{ url('/houses/new') }}" @endif style="cursor: pointer">میزبان شوید</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <div class="col-xs-12 hidden-sm hidden-xs">
                            <form class="navbar-form search-bar1" action="{{url('search')}}" role="phrase">
                                <div class="input-group add-on">
                                    <input class="form-control search-bar-input" placeholder="search.title"
                                           name="phrase" id="srch-term" type="text">
                                    <div class="input-group-btn">
                                        <button class="btn btn-default btn-search-1" type="submit" style="height: 36px"><i
                                                    class="glyphicon glyphicon-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>
                    @if (Auth::guest())
                        <li><a class="col-xs-12" data-toggle="modal" data-target="#login-modal" style="cursor: pointer; border: none">
                                <span>ورود</span>
                                <span style="border: 1px solid #eee; margin: 0 9px"></span>
                                <span>ثبت‌نام</span>
                            </a></li>
                        {{--<li><a class="col-xs-12" data-toggle="modal" data-target="#login-modal" style="cursor: pointer">ورود</a></li>--}}
                    @else
                        <li><a class="col-xs-12" href="{{ url('/trips') }}">سفرهای من</a></li>
                        <li><a class="col-xs-12" href="{{ url('/dashboard') }}">پنل کاربری</a></li>

                        <li class="dropdown" style="display: inline-block">
                            <a id="user" href="{{ url('/users/edit') }}" style="display: inline-block">

                                <div class="hidden-md hidden-sm newusername" style="display: inline-block">{{ Auth::user()->name }}</div>
                                <div class="user-pic hidden-xs">
                                    <img src="data:image/{{getPicture()}}">
                                </div>
                            </a>
                            {{--<ul class="dropdown-menu new-dr hidden-xs" style="margin-right: -40%;">--}}
                                {{--<li><a class="flt-rtl text-rtl" href="{{ url('/houses') }}">پنل کاربری</a></li>--}}
                                {{--<li><a class="flt-rtl text-rtl" href="{{ url('/users/edit') }}">تنظیمات کاربری</a></li>--}}
                                {{--<li><a class="flt-rtl text-rtl" href="{{ url('/logout') }}">خروج</a></li>--}}
                            {{--</ul>--}}
                        </li>

                    @endif
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <div class="container main-title">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="description"><span class="site-name">شب</span> اجاره روزانه ویلا</h2>
            </div>
        </div>
        <div class="hidden-lg hidden-md">
            <form class="navbar-form1 search-bar1" action="{{url('search')}}" role="phrase">
                <div class="input-group add-on">
                    <input class="form-control search-bar-input" style="width: 81% !important;"
                           placeholder="search.title" name="phrase" id="srch-term" type="text">
                    <div class="input-group-btn" style="width: auto">
                        <button class="btn btn-default btn-search-1" type="submit"><i
                                    class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="container icons mg-t-1">

        <div class="row">

            <div class="col-xs-12 col-md-5 margin-bottom-sm">
                <div class="row">
                    <div class="col-xs-8 col-sm-8 col-md-8 padding-item-menu">
                        <div style="color: #444">
                            <div id="l_cities" class="box main-icons cities_e icons_e pointer list_button pulse">
								<div class="col-xs-12 main-icons-img-container">
									<img src="../img/landing_page/icons/cities.png" alt="شهرها"/>
								</div>
								<span class="col-xs-12 title">انتخاب شهرها</span>
							</div>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 padding-item-menu">
                        <div style="color: #444">
                            <div id="l_tehran" class="box main-icons tehran_around icons_e pointer list_button">
                                <div class="col-xs-12 main-icons-img-container">
                                    <img src="../img/landing_page/icons/around_tehran.png" alt="اطراف تهران"/>
                                </div>
                                <span class="col-xs-12 title">اطراف تهران</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 padding-item-menu">
                        <div style="color: #444">
                            <div id="l_north" class="box main-icons north_e icons_e pointer list_button">
								<div class="col-xs-12 main-icons-img-container">
									<img src="../img/landing_page/icons/north.png" alt="شمال"/>
								</div>
								<span class="col-xs-12 title">شمال</span>
							</div>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 padding-item-menu">
                        <a style="color: #444" href="{{url('search?city=شیراز')}}">
                        <div style="color: #444">
                            <div id="l_kish" class="box main-icons group_e icons_e pointer list_button">
                                <div class="col-xs-12 main-icons-img-container">
                                    <img src="../img/landing_page/icons/hafez.png" alt="شیراز"/>
                                </div>
                                <span class="col-xs-12 title">شیراز</span>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 padding-item-menu">
                        <div style="color: #444">
                            <div id="l_village" class="box main-icons village_e icons_e pointer list_button">
								<div class="col-xs-12 main-icons-img-container">
									<img src="../img/landing_page/icons/village.png" alt="روستایی"/>
								</div>
								<span class="col-xs-12 title">خانه‌های روستایی</span>
							</div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-xs-12 col-md-7">
                <div class="row list_main list_row hidden-sm hidden-xs" style="margin: 0;">
                    <div class=" col-xs-12 box-wrapper-right">
						
						<div class="row howItWorks-container">
							<div class="col-xs-4 box-wrapper-right-img-container">
								<img src="/img/howItWorks-1.png" />
								<!--<svg width="45" height="45">
									  <circle cx="20" cy="25" r="20"
									  stroke="green" stroke-width="0.5" fill="#0faccb" />
								</svg>-->
								<span class="col-xs-12">
									<span> ۱) اقامتگاه مدنظرت رو از لیست شهرها انتخاب کن، با وارد کردن تاریخ، </span>
                                    <span style="font-weight: 700; color: #101010">درخواست رزرو</span>
                                    <span> بده تا </span>
                                    <span style="font-weight: 700; color: #101010">تاییدیه درخواست</span>
                                    <span> و لینک پرداخت برات پیامک می‌شه </span>
								</span>
							</div>
							<div class="col-xs-4 box-wrapper-right-img-container">
								<span class="col-xs-12 box-wrapper-right-topDown-txt">
									<span> ۲) با </span>
                                    <span style="font-weight: 700; color: #101010">پرداخت هزینه</span>
                                    <span> و امکان کنسلی، رزرو اقامتگاه انتخابی را با </span>
                                    <span style="font-weight: 700; color: #101010">ضمانت شب</span>
                                    <span> نهایی کن </span>
								</span>
								<img src="/img/howItWorks-2.png" />
							</div>
							<div class="col-xs-4 box-wrapper-right-img-container">
								<img src="/img/howItWorks-3.png" />
								<span class="col-xs-12">
                                    <span> ۳) </span>
                                    <span style="font-weight: 700; color: #101010">رسید سفر</span>
                                    <span> شامل آدرس و تلفن هماهنگ‌کننده‌ی اقامتگاه برات پیامک می‌شه، از سفرت لذت ببر </span>
								</span>
							</div>
						</div>
						
						
                    </div>
                </div>

                <div class="row list_tehran list_row hidden-sm" style="display: none">
                    <div class=" col-xs-12 box-wrapper-right">
                        <div class="col-xs-4 col-sm-4 col-md-6 pd-r-0">
                            <a style="color: #444" href="{{url('search?province=البرز,تهران')}}">
                                <div class="box main-icons all_e pos_e pointer">
									<div class="col-xs-12 main-icons-img-container">
										<img src="../img/landing_page/icons/all.png" alt="اجاره ویلا روزانه در اطراف تهران"/>
									</div>
									<span class="col-xs-12 title">نمایش همه</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-6 pd-r-0">
                            <a style="color: #444" href="{{url('search?province=البرز,تهران&min_accommodates=10')}}">
                                <div class="box main-icons large_e pos_e pointer">
									<div class="col-xs-12 main-icons-img-container">
										<img src="../img/landing_page/icons/large.png" alt="اجاره منزل مبله در تهران"/>
									</div>
									<span class="col-xs-12 title">گنجایش بالا</span>
								</div>
                            </a>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-6 pd-r-0">
                            <a style="color: #444" href="{{url('search?province=البرز,تهران&pool=1')}}">
                                <div class="box main-icons pool_e mg-t-15 pos_e pointer">
									<div class="col-xs-12 main-icons-img-container">
										<img src="../img/landing_page/icons/pool.png" alt="اجاره ویلا استخردار اطراف تهران"/>
									</div>
									<span class="col-xs-12 title">استخردار</span>
								</div>
                            </a>
                        </div>
                        <div class="col-xs-4 col-sm-4 mg-t-15 col-md-6 pd-r-0">
                            <a style="color: #444" href="{{url('search?province=البرز,تهران&private_yard=1')}}">
                                <div class="box main-icons hayat_e pos_e pointer">
									<div class="col-xs-12 main-icons-img-container">
										<img src="../img/landing_page/icons/hayat.png" alt="اجاره ویلا در تهران روزانه"/>
									</div>
									<span class="col-xs-12 title">حیاط دار</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="list_tehran_mobile list_row_mobile hidden-lg hidden-md" style="display: none">
                    <div class="list_mobile_close"><i class="fa fa-close"></i></div>
                    <div class="list_mobile_title"><span>اطراف تهران</span></div>
                    <div class=" col-xs-12 box-wrapper-right box_mobile">
                        <div class="row">
                            <div class="col-xs-6">
                                <a style="color: #444" href="{{url('search?province=البرز,تهران')}}">
                                    <div class="box main-icons all_e pos_e pointer">
										<div class="col-xs-12 main-icons-img-container">
											<img src="../img/landing_page/icons/all.png" alt="اجاره ویلا روزانه در اطراف تهران"/>
										</div>
										<span class="col-xs-12 title">نمایش همه</span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xs-6">
                                <a style="color: #444" href="{{url('search?province=البرز,تهران&min_accommodates=10')}}">
                                    <div class="box main-icons large_e pos_e pointer">
										<div class="col-xs-12 main-icons-img-container">
											<img src="../img/landing_page/icons/large.png" alt="اجاره منزل مبله در تهران"/>
										</div>
										<span class="col-xs-12 title">گنجایش بالا</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <a style="color: #444" href="{{url('search?province=البرز,تهران&pool=1')}}">
                                    <div class="box main-icons pool_e mg-t-15 pos_e pointer">
										<div class="col-xs-12 main-icons-img-container">
											<img src="../img/landing_page/icons/pool.png" alt="اجاره ویلا استخردار اطراف تهران"/>
										</div>
										<span class="col-xs-12 title">استخردار</span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xs-6">
                                <a style="color: #444" href="{{url('search?province=البرز,تهران&private_yard=1')}}">
                                    <div class="box main-icons pool_e mg-t-15 pos_e pointer">
										<div class="col-xs-12 main-icons-img-container">
											<img src="../img/landing_page/icons/hayat.png" alt="اجاره ویلا در تهران روزانه"/>
										</div>
										<span class="col-xs-12 title">حیاط دار</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row list_north list_row hidden-sm" style="display: none">
                    <div class="col-xs-12 box-wrapper-right">
                        <div class="col-xs-4 col-sm-4 col-md-6 pd-r-0">
                            <a style="color: #444" href="{{url('search?province=مازندران,گلستان,گیلان')}}">
                                <div class="box main-icons all_e pos_e pointer">
									<div class="col-xs-12 main-icons-img-container">
										<img src="../img/landing_page/icons/all.png" alt="اجاره ویلا در شمال"/>
									</div>
									<span class="col-xs-12 title">نمایش همه</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-6 pd-r-0">
                            <a style="color: #444" href="{{url('search?province=مازندران,گلستان,گیلان&pool=1')}}">
                                <div class="box main-icons pool_e pos_e pointer">
									<div class="col-xs-12 main-icons-img-container">
										<img src="../img/landing_page/icons/pool.png" alt="اجاره ویلا استخردار در شمال"/>
									</div>
									<span class="col-xs-12 title">استخردار</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-6 pd-r-0">
                            <a style="color: #444" href="{{url('search?province=مازندران,گلستان,گیلان&forest=1')}}">
                                <div class="box main-icons forest_e pos_e mg-t-15 pointer">
									<div class="col-xs-12 main-icons-img-container">
										<img src="../img/landing_page/icons/forest.png" alt="اجاره ویلا جنگلی در شمال"/>
									</div>
									<span class="col-xs-12 title">جنگلی</span>
								</div>
                            </a>
                        </div>
                        <div class="col-xs-4 col-sm-4 mg-t-15 col-md-6 pd-r-0">
                            <a style="color: #444" href="{{url('search?province=مازندران,گلستان,گیلان&coastal=1')}}">
                                <div class="box main-icons coastal_e pos_e pointer">
									<div class="col-xs-12 main-icons-img-container">
										<img src="../img/landing_page/icons/coastal.png" alt="اجاره ویلا ساحلی در شمال"/>
									</div>
									<span class="col-xs-12 title">ساحلی</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="list_north_mobile list_row_mobile hidden-lg hidden-md" style="display: none">
                    <div class="list_mobile_close"><i class="fa fa-close"></i></div>
                    <div class="list_mobile_title"><span>شمال</span></div>
                    <div class=" col-xs-12 box-wrapper-right box_mobile">
                        <div class="row">
                            <div class="col-xs-6">
                                <a style="color: #444" href="{{url('search?province=مازندران,گلستان,گیلان')}}">
                                    <div class="box main-icons all_e pos_e pointer">
										<div class="col-xs-12 main-icons-img-container">
											<img src="../img/landing_page/icons/all.png" alt="اجاره ویلا در شمال"/>
										</div>
										<span class="col-xs-12 title">نمایش همه</span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xs-6">
                                <a style="color: #444" href="{{url('search?province=مازندران,گلستان,گیلان&pool=1')}}">
                                    <div class="box main-icons pool_e pos_e pointer">
										<div class="col-xs-12 main-icons-img-container">
											<img src="../img/landing_page/icons/pool.png" alt="اجاره ویلا استخردار در شمال"/>
										</div>
										<span class="col-xs-12 title">استخردار</span>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="row mg-t-15">
                            <div class="col-xs-6">
                                <a style="color: #444" href="{{url('search?province=مازندران,گلستان,گیلان&forest=1')}}">
                                    <div class="box main-icons forest_e pos_e pointer">
										<div class="col-xs-12 main-icons-img-container">
											<img src="../img/landing_page/icons/forest.png" alt="اجاره ویلا جنگلی در شمال"/>
										</div>
										<span class="col-xs-12 title">جنگلی</span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xs-6">
                                <a style="color: #444" href="{{url('search?province=مازندران,گلستان,گیلان&coastal=1')}}">
                                    <div class="box main-icons coastal_e pos_e pointer">
										<div class="col-xs-12 main-icons-img-container">
											<img src="../img/landing_page/icons/coastal.png" alt="اجاره ویلا ساحلی در شمال"/>
										</div>
										<span class="col-xs-12 title">ساحلی</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row list_village list_row hidden-sm" style="display: none">
                    <div class=" col-xs-12 box-wrapper-right">
                        <div class="col-xs-4 col-sm-4 col-md-6 pd-r-0">
                            <a style="color: #444" href="{{url('search?rural=1')}}">
                                <div class="box main-icons all_e pos_e pointer">
									<div class="col-xs-12 main-icons-img-container">
										<img src="../img/landing_page/icons/all.png" alt="اجاره خانه در روستا"/>
									</div>
									<span class="col-xs-12 title">نمایش همه</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-6 pd-r-0">
                            <a style="color: #444" href="{{url('search?province=البرز,تهران&rural=1')}}">
                                <div class="box main-icons tehran_around pos_e pointer">
									<div class="col-xs-12 main-icons-img-container">
										<img src="../img/landing_page/icons/around_tehran.png" alt="اجاره ویلا اطراف تهران"/>
									</div>
									<span class="col-xs-12 title" style="color: #444">نزدیک تهران</span>
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-4 col-sm-4 mg-t-15 col-md-6 pd-r-0">
                            <a style="color: #444" href="{{url('search?rural=1&tag=تجربه_جدید')}}">
                                <div class="box main-icons tajrobe_e pos_e pointer">
									<div class="col-xs-12 main-icons-img-container">
										<img src="../img/landing_page/icons/tajrobe.png" alt="کلبه های روستایی"/>
									</div>
									<span class="col-xs-12 title">تجربه جدید</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-xs-4 col-sm-4 mg-t-15 col-md-6 pd-r-0">
                            <a style="color: #444" href="{{url('search?rural=1&tag=کلبه')}}">
                                <div class="box main-icons kolbe_e pos_e pointer">
									<div class="col-xs-12 main-icons-img-container">
										<img src="../img/landing_page/icons/kolbe.png" alt="اقامت در کلبه"/>
									</div>
									<span class="col-xs-12 title">کلبه ها</span>
								</div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="list_village_mobile list_row_mobile hidden-lg hidden-md" style="display: none">
                    <div class="list_mobile_close"><i class="fa fa-close"></i></div>
                    <div class="list_mobile_title"><span>خانه های روستایی</span></div>
                    <div class=" col-xs-12 box-wrapper-right box_mobile">
                        <div class="col-xs-6">
                            <a style="color: #444" href="{{url('search?rural=1')}}">
                                <div class="box main-icons all_e pos_e pointer">
									<div class="col-xs-12 main-icons-img-container">
										<img src="../img/landing_page/icons/all.png" alt="اجاره خانه روستایی"/>
									</div>
									<span class="col-xs-12 title">نمایش همه</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-xs-6">
                            <a style="color: #444" href="{{url('search?province=البرز,تهران&rural=1')}}">
                                <div class="box main-icons tehran_around pos_e pointer">
									<div class="col-xs-12 main-icons-img-container">
										<img src="../img/landing_page/icons/around_tehran.png" alt="اجاره ویلا اطراف تهران"/>
									</div>
									<span class="col-xs-12 title" style="color: #444">نزدیک تهران</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-xs-6 mg-t-15">
                            <a style="color: #444" href="{{url('search?rural=1&tag=تجربه_جدید')}}">
                                <div class="box main-icons all_e pos_e pointer">
									<div class="col-xs-12 main-icons-img-container">
										<img src="../img/landing_page/icons/tajrobe.png" alt="اجاره ویلا روستایی"/>
									</div>
									<span class="col-xs-12 title">تجربه جدید</span>
								</div>
                            </a>
                        </div>
                        <div class="col-xs-6 mg-t-15">
                            <a style="color: #444" href="{{url('search?rural=1&tag=کلبه')}}">
                                <div class="box main-icons all_e pos_e pointer">
									<div class="col-xs-12 main-icons-img-container">
										<img src="../img/landing_page/icons/kolbe.png" alt="کلبه های روستایی"/>
									</div>
									<span class="col-xs-12 title"> کلبه ها</span>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>


                <div class="row list_group list_row hidden-sm" style="display: none">
                    <div class=" col-xs-12 box-wrapper-right">
                        <div class="col-xs-4 col-sm-4 col-md-6 pd-r-0">
                            <a style="color: #444" href="{{url('search?city=مشهد&min_accommodates=10')}}">
                                <div class="box main-icons holy_e pos_e pointer">
									<div class="col-xs-12 main-icons-img-container">
										<img src="../img/landing_page/icons/holy.png" alt="زیارتی"/>
									</div>
									<span class="col-xs-12 title">زیارتی</span>
								</div>
                            </a>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-6 pd-r-0">
                            <a style="color: #444" href="{{url('search?tag=دل_طبیعت&min_accommodates=10')}}">
                                <div class="box main-icons nature_e pos_e pointer">
									<div class="col-xs-12 main-icons-img-container">
										<img src="../img/landing_page/icons/nature.png" alt="دل طبیعت"/>
									</div>
									<span class="col-xs-12 title">دل طبیعت</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-6 pd-r-0">
                            <a style="color: #444" href="{{url('search?tag=مجتمع')}}">
                                <div class="box main-icons large_capacity pos_e mg-t-15 pointer">
									<div class="col-xs-12 main-icons-img-container">
										<img src="../img/landing_page/icons/large_capacity.png" alt="مجتمع ها"/>
									</div>
									<span class="col-xs-12 title">مجتمع ها</span>
								</div>
                            </a>
                        </div>
                        <div class="col-xs-4 col-sm-4 mg-t-15 col-md-6 pd-r-0">
                            <a style="color: #444" href="{{url('search?min_accommodates=15')}}">
                                <div class="box main-icons large_e pos_e pointer">
									<div class="col-xs-12 main-icons-img-container">
										<img src="../img/landing_page/icons/large.png" alt="تعداد خیلی زیاد"/>
									</div>
									<span class="col-xs-12 title">تعداد خیلی زیاد</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="list_group_mobile list_row_mobile hidden-lg hidden-md" style="display: none">
                    <div class="list_mobile_close"><i class="fa fa-close"></i></div>
                    <div class="list_mobile_title"><span>اقامتگاه گروهی</span></div>
                    <div class="col-xs-12 box-wrapper-right box_mobile">
                        <div class="row">
                            <div class="col-xs-6">
                                <a style="color: #444" href="{{url('search?city=مشهد&min_accommodates=10')}}">
                                    <div class="box main-icons holy_e pos_e pointer">
										<div class="col-xs-12 main-icons-img-container">
											<img src="../img/landing_page/icons/holy.png" alt="زیارتی"/>
										</div>
										<span class="col-xs-12 title">زیارتی</span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xs-6">
                                <a style="color: #444" href="{{url('search?tag=دل_طبیعت&min_accommodates=10')}}">
                                    <div class="box main-icons nature_e pos_e pointer">
										<div class="col-xs-12 main-icons-img-container">
											<img src="../img/landing_page/icons/nature.png" alt="در طبیعت"/>
										</div>
										<span class="col-xs-12 title">دل طبیعت</span>
									</div>
                                </a>
                            </div>
                        </div>
                        <div class="row mg-t-15">
                            <div class="col-xs-6">
                                <a style="color: #444" href="{{url('search?tag=مجتمع')}}">
                                    <div class="box main-icons large_capacity pos_e pointer">
										<div class="col-xs-12 main-icons-img-container">
											<img src="../img/landing_page/icons/large_capacity.png" alt="مجتمع ها"/>
										</div>
										<span class="col-xs-12 title">مجتمع ها</span>
									</div>
                                </a>
                            </div>
                            <div class="col-xs-6">
                                <a style="color: #444" href="{{url('search?min_accommodates=15')}}">
                                    <div class="box main-icons large_e pos_e pointer">
										<div class="col-xs-12 main-icons-img-container">
											<img src="../img/landing_page/icons/large.png" alt="تعداد خیلی زیاد"/>
										</div>
										<span class="col-xs-12 title">تعداد خیلی زیاد</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row list_season list_row hidden-sm" style="display: none">
                    <div class=" col-xs-12 box-wrapper-right">
                        <div class="col-xs-4 col-sm-4 col-md-6 pd-r-0">
                            <a style="color: #444" href="{{url('search?summer=1')}}">
                                <div class="box main-icons cool_e pos_e pointer">
									<div class="col-xs-12 main-icons-img-container">
										<img src="../img/landing_page/icons/cool.png" alt="ییلاقی"/>
									</div>
									<span class="col-xs-12 title">خنک در تابستان (ییلاقی)</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-6 pd-r-0">
                            <a style="color: #444" href="{{url('search?province=هرمزگان,بوشهر,خوزستان')}}">
                                <div class="box main-icons hot_e pos_e pointer">
									<div class="col-xs-12 main-icons-img-container">
										<img src="../img/landing_page/icons/hot.png" alt="قشلاقی"/>
									</div>
									<span class="col-xs-12 title">گرم در زمستان (گرمسیری)</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="list_season_mobile list_row_mobile hidden-lg hidden-md" style="display: none">
                    <div class="list_mobile_close"><i class="fa fa-close"></i></div>
                    <div class="list_mobile_title"><span>اقامتگاه فصلی</span></div>
                    <div class=" col-xs-12 box-wrapper-right box_mobile">
                        <div class="row">
                            <div class="col-xs-6">
                                <a style="color: #444" href="{{url('search?summer=1')}}">
                                    <div class="box main-icons cool_e pos_e pointer">
										<div class="col-xs-12 main-icons-img-container">
											<img src="../img/landing_page/icons/cool.png" alt="ییلاقی"/>
										</div>
										<span class="col-xs-12 title">خنک در تابستان (ییلاقی)</span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xs-6">
                                <a style="color: #444" href="{{url('search?province=هرمزگان,بوشهر,خوزستان')}}">
                                    <div class="box main-icons hot_e pos_e pointer">
										<div class="col-xs-12 main-icons-img-container">
											<img src="../img/landing_page/icons/hot.png" alt="گرمسیری"/>
										</div>
										<span class="col-xs-12 title">گرم در زمستان (گرمسیری)</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="list_cities list_row_city hidden-sm" style="display: none">
                    <div class="list_mobile_close"><i class="fa fa-close"></i></div>
                    <div class="list_mobile_title"><span>انتخاب شهرها</span></div>
                    <div class=" col-xs-12 box-wrapper-right box_mobile" style="overflow: scroll;">
						<div class="col-xs-3" id="chooseCityColumn0"></div>
						<div class="col-xs-3" id="chooseCityColumn1"></div>
						<div class="col-xs-3" id="chooseCityColumn2"></div>
						<div class="col-xs-3" id="chooseCityColumn3"></div>
                    </div>
                    <div class="search_button search_button_web" style="display: none">
						<a id="search_url" class="search_url" href="{{ url('/search') }}?destination=">
                            <button type="button" class="btn btn-success">نمایش همه</button>
                        </a>
					</div>
                </div>

                <div class="list_cities_mobile list_row_mobile hidden-lg hidden-md" style="display: none">
                    <div class="list_mobile_close"><i class="fa fa-close"></i></div>
                    <div class="list_mobile_title"><span>انتخاب شهرها</span></div>
                    <div class=" col-xs-12 box-wrapper-right box_mobile" style="overflow: scroll;">
						<div class="col-xs-6" id="mobileChooseCityColumn0"></div>
						<div class="col-xs-6" id="mobileChooseCityColumn1"></div>
					</div>
                </div>
            </div>
            <div class="search_button search_button_mobile" style="display: none;"><a id="search_url" class="search_url"
                                                                                      href="{{ url('/search') }}">
                    <button type="button" class="btn btn-success">نمایش همه</button>
                </a></div>
        </div>


    </div>

    </div>
    </div>

</header>


<main>
    <div class="container-fluid separator">
        {{--<div class="row">--}}
            {{--<div class="col-xs-12 ">--}}
                {{--<div class="content content_empty"></div>--}}
            {{--</div>--}}
        {{--</div>--}}
    </div>

    <div class="container">
        <div class="suggestion">
            <div class="row">
                <div class="col-xs-12 title-container">
                    <a href="/search/tag/ویژه_نوروز_97">
                        <div class="pull-right" style="padding: 0"><h2 class="title">پیشنهاد ویژه</h2></div>
                    </a>

                    <a href="/search/tag/ویژه_نوروز_97"><small>مشاهده همه</small></a>
                </div>
            </div>
        </div>
        <div id="special-noruz-carousel" class="gallery js-flickity" data-flickity-options='{ "freeScroll": true, "wrapAround": true }'>
        </div>
    </div>

    {{--<section class="slider1 slider_default s5">--}}
    {{--</section>--}}

    <div class="container">
        <div class="suggestion">
            <div class="row">
                <div class="col-xs-12 title-container">
                    <a href="/search/tag/مجلل">
                        <div class="pull-right" style="padding: 0"><h2 class="title">اجاره ویلاهای مجلل</h2></div>
                    </a>

                    <a href="/search/tag/مجلل"><small>مشاهده همه</small></a>
                </div>
            </div>
        </div>
        <div id="luxury-carousel" class="gallery js-flickity" data-flickity-options='{ "freeScroll": true, "wrapAround": true }'>
        </div>
    </div>


    <div class="container">
        <div class="suggestion">
            <div class="row">
                <div class="col-xs-12 title-container">
                    <a href="/search/tag/اطراف_تهران">
                        <div class="pull-right" style="padding: 0"><h3 class="title">اجاره ویلا در اطراف تهران</h3></div>
                    </a>

                    <a href="/search/tag/اطراف_تهران"><small>مشاهده همه</small></a>
                </div>
            </div>
        </div>
        <div id="tehranVillas-carousel" class="gallery js-flickity" data-flickity-options='{ "freeScroll": true, "wrapAround": true }'>
        </div>
    </div>


    <div class="container">
        <div class="suggestion">
            <div class="row">
                <div class="col-xs-12 title-container">
                    <a href="/search/tag/پرطرفدارترین">
                        <div class="pull-right" style="padding: 0"><h2 class="title">پرطرفدارترین</h2></div>
                    </a>

                    <a href="/search/tag/پرطرفدارترین"><small>مشاهده همه</small></a>
                </div>
            </div>
        </div>
        <div id="popular-carousel" class="gallery js-flickity" data-flickity-options='{ "freeScroll": true, "wrapAround": true }'>
        </div>
    </div>


    <div class="container">
        <div class="suggestion">
            <div class="row">
                <div class="col-xs-12 title-container">
                    <a href="/blog">
                        <div class="pull-right" style="padding: 0; padding-left: 1em"><div class="title">دانستنی‌های سفر</div></div>
                    </a>

                    <a href="/blog"><small>مشاهده همه</small></a>
                </div>
            </div>
        </div>
        <div id="blog-carousel" class="gallery js-flickity" data-flickity-options='{ "freeScroll": true, "wrapAround": true }'>
        </div>
    </div>


    <div class="container-fluid separator sep_tel">
        <div class="row">
            <div class="col-xs-12">
                <div class="content">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <a style="text-decoration: none" href="https://telegram.me/shab_ir" target="_blank">
                                    <p class="text telegram">برای آگاهی از تخفیفات ویژه و لحظه آخری در کانال تلگرام ما
                                        عضو شوید
                                        &nbsp;&nbsp;<i class="fa fa-paper-plane" aria-hidden="true"></i>
                                    </p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	
						
	<div class="howItWorks-container visible-sm visible-xs" style="margin-bottom: 30px">
		<div class="col-xs-12 col-sm-4 box-wrapper-right-img-container mobile-howItWorks-img-container" style="margin-bottom: 20px;">
			<img class="mobile-howItWorks-img" src="/img/howItWorks-1.png" />
			<!--<svg width="45" height="45">
				  <circle cx="20" cy="25" r="20"
				  stroke="green" stroke-width="0.5" fill="#0faccb" />
			</svg>-->
			<span class="col-xs-12 mobile-howItWorks-txt" style="text-align: center">
				<span> ۱) اقامتگاه مدنظرت رو از لیست شهرها انتخاب کن، با وارد کردن تاریخ، </span>
                <span style="font-weight: 700; color: #101010">درخواست رزرو</span>
                <span> بده تا </span>
                <span style="font-weight: 700; color: #101010">تاییدیه درخواست</span>
                <span> و لینک پرداخت برات پیامک بشه </span>
			</span>
		</div>
		<div class="col-xs-12 col-sm-4 box-wrapper-right-img-container mobile-howItWorks-img-container" style="margin-bottom: 20px;">
			<img class="mobile-howItWorks-img" src="/img/howItWorks-2.png" />
			<span class="col-xs-12 mobile-howItWorks-txt" style="text-align: center">
                <span> ۲) با </span>
                <span style="font-weight: 700; color: #101010">پرداخت هزینه</span>
                <span> و امکان کنسلی، رزرو اقامتگاه انتخابی را با </span>
                <span style="font-weight: 700; color: #101010">ضمانت شب</span>
                <span> نهایی کن </span>
            </span>
        </div>
		<div class="col-xs-12 col-sm-4 box-wrapper-right-img-container mobile-howItWorks-img-container" style="margin-bottom: 20px;">
			<img class="mobile-howItWorks-img" src="/img/howItWorks-3.png" />
			<span class="col-xs-12 mobile-howItWorks-txt" style="text-align: center">
                <span> ۳) </span>
                <span style="font-weight: 700; color: #101010">رسید سفر</span>
                <span> شامل آدرس و تلفن هماهنگ‌کننده‌ی اقامتگاه برات پیامک می‌شه، از سفرت لذت ببر </span>
            </span>
		</div>
	</div>

</main>

<footer>


    <div class="container footer-links">

        <hr>

        <div class="row">

            <div class="col-xs-12 col-md-4 text-center-sm margin-bottom-sm--">
                <div class="meta">
                    <ul class="meta-list">
                        <li class="meta-item"><a class="meta-link" href="{{ url('/policies') }}">قوانین استفاده از
                                شب</a></li>
                        <li class="meta-item"><a class="meta-link" href="{{ url('/careers') }}">همکاری با شب</a></li>
                        <li class="meta-item"><a class="meta-link" href="{{ url('/about') }}">درباره شب</a></li>
                        <li class="meta-item"><a class="meta-link" href="{{ url('/terms') }}">حقوق کاربران در شب</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xs-12 col-md-4 text-center-sm margin-bottom-sm">
                <div class="meta">
                    <ul class="meta-list">
                        {{-- <li class="hidden-lg hidden-md hidden-sm"><p></p></li> --}}
                        <li class="meta-item"><a class="meta-link" href="{{ url('/refund') }}">قواعد شب درباره بازپرداخت
                                وجوه</a></li>
                        <li class="meta-item"><a class="meta-link" href="{{ url('/help/host') }}">نحوه کار شب</a></li>
                        <li class="meta-item"><a class="meta-link" href="{{ url('/complaints') }}">ثبت شکایات</a></li>
                        <li class="meta-item"><a class="meta-link" href="{{ url('/blog') }}">وبلاگ شب</a></li>
                    </ul>
                </div>
            </div>
            {{--<div style="text-align:center">--}}
                {{--<img id='jzpejzpeoeukapfufukz' style='cursor:pointer'--}}
                                                {{--onclick='window.open("https://logo.samandehi.ir/Verify.aspx?id=77856&p=jyoejyoemcsidshwgvka", "Popup","toolbar=no, scrollbars=no, location=no, statusbar=no, menubar=no, resizable=0, width=450, height=630, top=30")'--}}
                                                {{--alt='logo-samandehi'--}}
                                                {{--src='https://logo.samandehi.ir/logo.aspx?id=77856&p=yndtyndtaqgwujynwlbq'/>--}}
                {{--<img src="//trustseal.enamad.ir/logo.aspx?id=60978&p=lznbzpfvgthvpeukpeuk" alt="" onclick="window.open('https://trustseal.enamad.ir/Verify.aspx?id=60978&p=nbpdjzpgdrfsqgwlqgwl', 'Popup','toolbar=no, location=no, statusbar=no, menubar=no, scrollbars=1, resizable=0, width=580, height=600, top=30')" style="cursor:pointer" id="drftgwmdsguilbrhlbrh">--}}

            {{--</div>--}}

            <div class="col-xs-12 col-md-4 text-center-sm margin-bottom-sm">
                <div class="info">
                    <p>آدرس: تهران، خیابان شریعتی، نرسیده به میدان قدس، کوچه پروین، پلاك 18 ،واحد 6</p>
                    <p>
                    <span>تلفن: 02122398202</span>
                    <span>کدپستی: 1933947754</span>
                    </p>
                </div>
            </div>
        </div>

        <hr>

    </div>

    <div class="container-fluid separator social">
        <div class="row social-container">
            <div class="col-xs-2-4 social-item facebook"><a class="social-link" href="https://facebook.com/shabDOTir"
                                                            target="_blank"><i class="fa fa-facebook"></i></a></div>
            <div class="col-xs-2-4 social-item linkedin"><a class="social-link" href="https://www.linkedin.com/company/shab.ir"
                                                            target="_blank"><i class="fa fa-linkedin"></i></a></div>
            <div class="col-xs-2-4 social-item aparat"><a class="social-link" href="https://aparat.com/shab.ir"
                                                          target="_blank"><i class="fa fa-facebook fa-aparat"></i></a>
            </div>
            <div class="col-xs-2-4 social-item instagram"><a class="social-link" href="https://instagram.com/_shab.ir"
                                                             target="_blank"><i class="fa fa-instagram"></i></a></div>
            <div class="col-xs-2-4 social-item googleplus"><a class="social-link"
                                                              href="https://plus.google.com/109089824001381609228"
                                                              target="_blank"><i class="fa fa-google-plus"></i></a>
            </div>
        </div>
    </div>


    <div class="container footer-information" style="margin-top: 30px">
        <div class="row footer-info" style="padding: 0;">
            <div class="col-xs-12 col-md-8 text-center-sm margin-bottom-sm" >
                <h5>اجاره ویلا در سراسر ایران</h5>
                <div class="info" style="text-align: justify; font-size: 12px">
                    <p>
                        محل اقامت شما مهم است. سایت شب برای بهبود کیفیت اقامت در منازل شخصی تاسیس شد.حاصل فعالیت یکساله مجموعه شب ارائه هزاران اقامتگاه شخصی مطمئن و ده ها هزار شب اقامت در نقاط مختلف کشور است.هدف این مجموعه ایجاد بستر لازم برای معرفی اقامتگاههای  شخصی سلامت و جذاب کشورمان و ایجاد تجربه های نو برای میهمانان است.شب به عنوان اولبن مجموعه اجاره روزانه با نظارت بر کیفیت اقامت در فضای مجازی، افتخار همکاری با میزبانان متعهد و میهمانان با سلایق متنوع را داشته است. شب با مدلسازی کامل فضای اجاره ویلای کشور موفق به خلق مسیری مطمئن برای تضمین  پرداخت ، اصالت و نظافت منازل گشته و باپشتیبانی 24 ساعته و تیم تامین رضایت مشتری ، در هرلحظه از اقامت همراه شماست. شما در سایت شب می‌توانید از شهرهای بزرگ تا روستا های دنج ایران،   اقامتگاه شخصی خود را رزرو کنید.کافیست  در سایت شب اجاره ویلا در شمال، اجاره ویلا در کیش، اجاره ویلا در تهران و اطراف تهران و اجاره روزانه آپارتمان درمشهد یا سایر شهرها را انتخاب کنید. سایت شب پرداخت شما را تضمین کرده و قابلیت استرداد وجه و پرداخت مبلغ لغو رزرو را داراست.
                    </p>
                </div>
            </div>

            <div class="col-xs-12 col-md-4 text-center-sm margin-bottom-sm address-container-newLanding">
                <div class="info">

                    <img id='jzpejzpeoeukapfufukz' style='cursor:pointer'
                         onclick='window.open("https://logo.samandehi.ir/Verify.aspx?id=77856&p=jyoejyoemcsidshwgvka", "Popup","toolbar=no, scrollbars=no, location=no, statusbar=no, menubar=no, resizable=0, width=450, height=630, top=30")'
                         alt='logo-samandehi'
                         src='https://logo.samandehi.ir/logo.aspx?id=77856&p=yndtyndtaqgwujynwlbq'/>
                    <img src="https://trustseal.enamad.ir/logo.aspx?id=60978&p=lznbzpfvgthvpeukpeuk" alt="" onclick="window.open('https://trustseal.enamad.ir/Verify.aspx?id=60978&p=nbpdjzpgdrfsqgwlqgwl', 'Popup','toolbar=no, location=no, statusbar=no, menubar=no, scrollbars=1, resizable=0, width=580, height=600, top=30')" style="cursor:pointer" id="drftgwmdsguilbrhlbrh">

                </div>
            </div>

            <div class="col-xs-12 city-container hidden-xs">
                <div class="col-xs-12 text-center-sm margin-bottom-sm">
                    <div class="info">
                        <p>
                            <div class="col-xs-4 footer-links" style="padding: 0 3px">
                                <h5>ویلاهای شمال</h5>
                                <div class="meta-item city-link"><a class="meta-link" href="/search/city/چالوس">اجاره ویلا در چالوس</a></div>
                                <div class="meta-item city-link"><a class="meta-link" href="/search/city/کلاردشت">اجاره ویلا در کلاردشت</a></div>
                                <div class="meta-item city-link"><a class="meta-link" href="/search/city/تالش">اجاره ویلا در تالش</a></div>
                                <div class="meta-item city-link"><a class="meta-link" href="/search/city/فومن">اجاره ویلا در فومن</a></div>
                                <div class="meta-item city-link"><a class="meta-link" href="/search/city/بابلسر">اجاره ویلا در بابلسر</a></div>
                                <div class="meta-item city-link"><a class="meta-link" href="/search/city/محمود آباد">اجاره ویلا در محمود آباد</a></div>
                                <div class="meta-item city-link"><a class="meta-link" href="/search/city/فریدون كنار">اجاره ویلا در فریدون کنار</a></div>
                                <div class="meta-item city-link"><a class="meta-link" href="/search/city/نوشهر">اجاره ویلا در نوشهر</a></div>
                            </div>

                            <div class="col-xs-4 footer-links" style="padding: 0 3px">
                                <h5>ویلاهای جنوب</h5>
                                <div class="meta-item city-link"><a class="meta-link" href="/search/city/شیراز">اجاره ویلا در شیراز</a></div>
                                <div class="meta-item city-link"><a class="meta-link" href="/search/city/بندرعباس">اجاره ویلا در بندرعباس</a></div>
                                <div class="meta-item city-link"><a class="meta-link" href="/search/province/هرمزگان">اجاره ویلا در هرمزگان</a></div>
                                <div class="meta-item city-link"><a class="meta-link" href="/search/city/قشم">اجاره ویلا در قشم</a></div>
                                <div class="meta-item city-link"><a class="meta-link" href="/search/city/كیش">اجاره ویلا در كیش</a></div>
                                <div class="meta-item city-link"><a class="meta-link" href="/search/city/جزیره هرمز">اجاره ویلا در جزیره هرمز</a></div>
                                <div class="meta-item city-link"><a class="meta-link" href="/search/city/یزد">اجاره ویلا در یزد</a></div>
                                <div class="meta-item city-link"><a class="meta-link" href="/search/city/همدان">اجاره ویلا در همدان</a></div>
                            </div>

                            <div class="col-xs-4 footer-links" style="padding: 0 3px">
                                <h5>ویلاهای اطراف تهران</h5>
                                <div class="meta-item city-link"><a class="meta-link" href="/search/city/تهران">اجاره ویلا در تهران</a></div>
                                <div class="meta-item city-link"><a class="meta-link" href="/search/city/بومهن">اجاره ویلا در بومهن</a></div>
                                <div class="meta-item city-link"><a class="meta-link" href="/search/city/دماوند">اجاره ویلا در دماوند</a></div>
                                <div class="meta-item city-link"><a class="meta-link" href="/search/city/لواسان">اجاره ویلا در لواسان</a></div>
                                <div class="meta-item city-link"><a class="meta-link" href="/search/city/طالقان">اجاره ویلا در طالقان</a></div>
                                <div class="meta-item city-link"><a class="meta-link" href="/search/city/كردان">اجاره ویلا در کردان</a></div>
                                <div class="meta-item city-link"><a class="meta-link" href="/search/city/فیروزكوه">اجاره ویلا در فیروزکوه</a></div>
                            </div>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</footer>

<?php $i = 0;

$provinces = \App\House::distinct()->select('province')->where('temp', 0)->where('disabled', 0)->orderBy('province', 'asc')->get(); $count = 10;
$cities = array();
?>
<!-- get cities from db -->

@foreach($provinces as $province)
    <?php
    $available_cities = \App\House::distinct()->select('city')->where('temp', 0)->where('disabled', 0)->where('province', $province['province'])->orderBy('city', 'asc')->get();
    $cities[$province['province']] = $available_cities;
    $i = 0;
    foreach ($available_cities as $city) {
        $cities[$province['province']][$i]['count'] = \App\House::where('city', $city['city'])->where('temp', 0)->where('disabled', 0)->get()->count();
        $i++;
    }
    ?>
@endforeach
</body>
<script src="{{ asset('js/flickity.pkgd.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('js/bookmarks.js?v=0.0.4') }}" type="text/javascript"></script>

<script>
    $('.slider6').flickity({
        // options
        cellAlign: 'left',
        contain: true
    });
</script>


<script type="text/javascript">

    function houseType(type) {
        if (type == 'villa')
            return 'ویلایی';
        else if (type == 'room')
            return 'سوییت';
        else
            return 'آپارتمان';
    }

    $('.list_mobile_close').click(function () {
        $(this).parent().slideToggle(400);
        $('body').css('overflow', 'visible');
        $('.search_button').hide();
        $('.list_main').show();
    });

    $('.list_button:not(#l_kish)').click(function () {
        $('.list_button').each(function () {
            $(this).removeClass('l_selected').addClass('l_hide').removeClass('pulse');
        });
        $(this).addClass('l_selected').removeClass('l_hide');

        $('.list_row').each(function () {
            $(this).hide();
        });

        if ($(window).width() < 992) {
            $('body').css('overflow', 'hidden');
            switch (this.id) {
                case 'l_cities':
                    $('.list_cities_mobile').slideToggle(200);
                    $('.search_button_mobile').show();
                    break;

                case 'l_tehran':
                    $('.list_tehran_mobile').slideToggle(400);

                    break;

                case 'l_north':
                    $('.list_north_mobile').slideToggle(400);

                    break;

                case 'l_village':
                    $('.list_village_mobile').slideToggle(400);

                    break;
            }
        }
        else {
            switch (this.id) {
                case 'l_cities':
                    $('.list_cities').slideToggle(400);
                    $('body').css('overflow', 'hidden');
                    $('.search_button_web').show();
                    break;

                case 'l_tehran':
                    $('.list_tehran').show();

                    break;

                case 'l_north':
                    $('.list_north').show();

                    break;

                case 'l_village':
                    $('.list_village').show();

                    break;
            }
        }
    });


function init_slider(className) {
    $('.'+className).slick({
        rtl: true,
        nextArrow: '<div class="slider-next"><i class="slider-icon fa fa-chevron-left"></i></div>',
        prevArrow: '<div class="slider-prev"><i class="slider-icon fa fa-chevron-right"></i></div>',
        infinite: false,
        speed: 300,
        slidesToShow: 3.5,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    infinite: false,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: false,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: false,
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });
}

    var lastSlide = $('.slick-slide').length - 4; // minos count of displayed slides
    if ($(window).width() < 1024)
        lastSlide = $('.slick-slide').length - 2; // minos count of displayed slides
    if ($(window).width() < 480)
        lastSlide = $('.slick-slide').length - 1; // minos count of displayed slides
    if (lastSlide < 0)
        lastSlide = $('.slick-slide').length;
    $('.slider-prev i').css('color', '#dddddd');
    $('.slider_default').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
        if (nextSlide > 0) {
            $('.slider-prev i').css('color', '#777777');
            if (nextSlide == lastSlide) {
                $('.slider-next i').css('color', '#dddddd');
            }
            else {
                $('.slider-next i').css('color', '#777777');
            }
        }
        else {
            $('.slider-prev i').css('color', '#dddddd');
            if (lastSlide >= 1) {
                $('.slider-next i').css('color', '#777777');
            }
        }
    });

    function navBottom() {
        $('html, body').animate({
            scrollTop: $('footer').offset().top
        }, 'slow');
    }

    function blogPost(post, image) {

        var txt="";
        txt += '<div onmouseover="showMarker(this.id)" onmouseout="hideMarker(this.id)" class="gallery-cell list-item item-similar" marker="19" id="'+post.id+'"> <!— search result item —>';
        txt += '<a href="/blog?p='+post.id+'" target="_blank" id="item-a" class="item-desc">';
        txt += '<div class="item-main">';

        txt += '<div class="image-price-container">';
        txt += '<img src="'+image+'" class="fullImg" alt="'+post.post_title+'" style="width: 100%; height: 100%; position: absolute; top: 0;">';
        txt += '<div class="item-price item-price3" style="display: none">';
        txt += '<span class="priceReadable">از ';
        txt += '<span id="item-price">'+digitsToHindi(2000)+'</span>';
        txt += ' هزار تومان</span>';
        txt += '</div>';
        txt += '</div>';
        txt += '<div class="load-spinner"></div>';

        txt += '</div>';

        txt += '<div class="panel-card-section">';
        txt += '<div class="media">';
        txt += '<div class="item-info">';
        txt += '<span>';

        txt += '<h4 class="item-title">'+post.post_title+'</h4>';
        txt += '<div style="display: none">';

        txt += '<span class="col-xs-12" id="item-location">';
        //txt += '<i class="fa fa-map-marker" aria-hidden="true"></i> ';
        txt += '<span>آذربایجان</span>';
        txt += '&nbsp;';
        txt += '<span class="item-sign">&minus;</span>';
        txt += '&nbsp;';
        txt += '<span>سراب</span>';
        txt += '</span>';
        txt += '</div>';


        txt += '<div style="display: none">';
        txt += '<span class="col-xs-7" id="item-type">';
        txt += '<span>';
        txt += 'ویلا';
        txt += '</span>';
        txt += '<span class="item-sign">&nbsp; | &nbsp;</span>';
        txt += '<span>';
        txt += '<span class="item-bold">'+digitsToHindi(2)+'</span>';
        txt += '&nbsp;';
        txt += 'اتاق';
        txt += '</span>';
        txt += '<span class="item-sign">&nbsp; | &nbsp;</span>';
        txt += '<span>';
        txt += 'تا';
        txt += '&nbsp;';
        txt += '<span class="item-bold">'+digitsToHindi(4)+'</span>';
        txt += '&nbsp;';
        txt += 'نفر';
        txt += '</span>';
        txt += '</span>';

        txt += '<div class="col-xs-5 star-rating">';
        //txt += '<span id="reviewCount">۲۴</span>&nbsp;<span>رزرو</span>';
        txt += '<div class="background">';
        txt += '<i class="fa fa-star"></i>';
        txt += '<i class="fa fa-star"></i>';
        txt += '<i class="fa fa-star"></i>';
        txt += '<i class="fa fa-star star-0"></i>';
        txt += '<i class="fa fa-star star-0"></i>';
        txt += '</div>';
        txt += '</div>';
        txt += '</div>';


        txt += '</span>';
        txt += '</div>';
        txt += '</div>';
        txt += '</div>';
        txt += '</a>';
        txt += '</div>';

        return txt;

    }

    $(document).ready(function () {
        $.when(
            $.ajax({
                type: "POST",
                url: "/search?tag=ویژه_نوروز_97",
                success: function(slider_special) {
                    var houses = shuffleArray(slider_special.data);
                    var $carousel = $('#special-noruz-carousel').flickity();

                    for(var i=0; i<houses.length; i++) {
                        var $cellElems = $(houseItemMaker(houses[i], true, "{{Auth::guest()}}", 0));
                        $carousel.flickity( 'prepend', $cellElems );
                    }
                    $carousel.flickity('select', 0, true, true );
                }
            }),

            $.ajax({
                type: "POST",
                url: "/search?tag=مجلل",
                success: function(slider_special) {
                    var houses = shuffleArray(slider_special.data);
                    var $carousel = $('#luxury-carousel').flickity();


                    for(var i=0; i<houses.length; i++) {
                        var $cellElems = $(houseItemMaker(houses[i], true, "{{Auth::guest()}}", 0));
                        $carousel.flickity( 'prepend', $cellElems );
                    }
                    $carousel.flickity('select', 0, true, true );
                }
            }),

            $.ajax({
                type: "POST",
                url: "/search?tag=اطراف_تهران",
                success: function(slider_special) {
                    var houses = shuffleArray(slider_special.data);
                    var $carousel = $('#tehranVillas-carousel').flickity();

                    for(var i=0; i<houses.length; i++) {
                        var $cellElems = $(houseItemMaker(houses[i], true, "{{Auth::guest()}}", 0));
                        $carousel.flickity( 'prepend', $cellElems );
                    }
                    $carousel.flickity('select', 0, true, true );
                }
            }),

            $.ajax({
                type: "POST",
                url: "/search?tag=پرطرفدارترین",
                success: function(slider_special) {
                    var houses = shuffleArray(slider_special.data);
                    var $carousel = $('#popular-carousel').flickity();

                    for(var i=0; i<houses.length; i++) {
                        var $cellElems = $(houseItemMaker(houses[i], true, "{{Auth::guest()}}", 0));
                        $carousel.flickity( 'prepend', $cellElems );
                    }
                    $carousel.flickity('select', 0, true, true );
                }
            })
        ).then(function(){console.log();configHouse()});

        $.ajax({
            type: "GET",
            url: "/blog_posts",
            success: function(slider_special) {
                var $carousel = $('#blog-carousel').flickity()
                for(var i=0; i<slider_special.posts.length; i++) {
                    for(var j=0; j<slider_special.posts_thumbnails.length; j++) {
                        if (slider_special.posts[i].meta_value == slider_special.posts_thumbnails[j].id) {
                            var $cellElems = $(blogPost(slider_special.posts[i], slider_special.posts_thumbnails[j].guid))
                            $carousel.flickity('prepend', $cellElems);
                        }
                    }
                }
                $carousel.flickity( 'select', 0, true, true );
            }
        });


        $('.slider_default').css('visibility', 'visible');

        function slider_loop() {
            window.setInterval(function () {
                var $active = $('ul.sh-slider .active');
                var $next = ($active.next().length > 0) ? $active.next() : $('ul.sh-slider li:first');
                // $next.css('z-index', 2);
                $active.fadeOut(1500, function () {
                    $active.show().removeClass('active');
                    $next.addClass('active');
                });
            }, 30000);
        }

        $('#province-select').children().each(function () {
            var pr = this.value;
            var removeItem = true;
            for (i = 1; i < Object.keys(PROVINCES).length + 1; i++) {
                if (PROVINCES[i] == pr || pr == 'province') {
                    removeItem = false;
                }
            }
            if (removeItem) {
                this.remove();
            }
        });


        $('#province-select').on('change', function (e) {
            var cities = getCitiesForProvince(this.value);
            setCities(cities, this.value);
        });

    });


    function digitsToHindi(str) {
        if (str == undefined) return '';
        str = str.toString();
        str = str.replace(/0/g, '۰');
        str = str.replace(/1/g, '۱');
        str = str.replace(/2/g, '۲');
        str = str.replace(/3/g, '۳');
        str = str.replace(/4/g, '۴');
        str = str.replace(/5/g, '۵');
        str = str.replace(/6/g, '۶');
        str = str.replace(/7/g, '۷');
        str = str.replace(/8/g, '۸');
        str = str.replace(/9/g, '۹');
        return str;
    }
    function digitsToLatin(str) {
        if (str == undefined) return '';
        str = str.toString();
        str = str.replace(/۰/g, '0');
        str = str.replace(/۱/g, '1');
        str = str.replace(/۲/g, '2');
        str = str.replace(/۳/g, '3');
        str = str.replace(/۴/g, '4');
        str = str.replace(/۵/g, '5');
        str = str.replace(/۶/g, '6');
        str = str.replace(/۷/g, '7');
        str = str.replace(/۸/g, '8');
        str = str.replace(/۹/g, '9');
        return str;
    }

    function setCities(citiesList, provinceName) {
        $('#city-select').empty().append('<option value="city">شهر</option>');
        // for (i = 0; i < Object.keys(citiesList).length; i++) {
        if (available_cities[provinceName].length > 0) {
            for (var j = 0; j < available_cities[provinceName].length; j++) {
                var city = available_cities[provinceName][j];
                $('#city-select').append('<option value="' + city['city'] + '">' + city['city'] + '</option>');
            }
        }
        // }
    }

    function getCitiesForProvince(pr) {
        var prCode = 0;
        var citiesForPr = [];
        for (var key in PROVINCES) {
            if (PROVINCES[key] == pr) {
                prCode = key;
            }
        }

        for (var key in CITIES) {
            if (CITIES[key] == prCode) {
                citiesForPr.push(key);
            }
        }
        return citiesForPr;
    }


    var available_cities = <?php echo json_encode($cities); ?>;
    var i = 0;
    for (key in available_cities) {
        if ($(window).width() < 992) {
			$('#mobileChooseCityColumn'+i%2).append('<div class="col-xs-12 i_city" id="city'+i+'mobileChooseCityColumn'+i%2+'"></div>');
			$('#city'+i+'mobileChooseCityColumn'+i%2).append('<p class="list_province">استان ' + key + '</p>');
			for (var j = 0; j < available_cities[key].length; j++) {
				$('#city'+i+'mobileChooseCityColumn'+i%2).append('<div class="col-xs-12 list_city"><span class="chooseCity-citiesName">' + available_cities[key][j].city + '</span><span class="chooseCity-houseCount"> (' + available_cities[key][j].count + ' خانه)</span></div>');
			}       
            i++;  
        }
        else {
			$('#chooseCityColumn'+i%4).append('<div class="col-xs-12 i_city" id="city'+i+'chooseCityColumn'+i%4+'"></div>');
			$('#city'+i+'chooseCityColumn'+i%4).append('<p class="list_province">استان ' + key + '</p>');
			for (var j = 0; j < available_cities[key].length; j++) {
				$('#city'+i+'chooseCityColumn'+i%4).append('<div class="col-xs-12 list_city"><span class="chooseCity-citiesName">' + available_cities[key][j].city + '</span><span class="chooseCity-houseCount"> (' + available_cities[key][j].count + ' خانه)</span></div>');
			}       
            i++;
        }
    }

    var selected_cities = [];
    var search_url = $('#search_url').attr('href');
    $(document).on('click', '.list_city', function () {
        if (!$(this).hasClass('c_selected')) {
            selected_cities.push($(this).text().substr(0, $(this).text().lastIndexOf('(') - 1));
            $(this).addClass('c_selected');
        }
        else {
            var index = selected_cities.lastIndexOf($(this).text().substr(0, $(this).text().lastIndexOf('(') - 1));
            selected_cities.splice(index, 1);
            $(this).removeClass('c_selected');
            if (selected_cities.length == 0) {
                $(this).parent().find('.list_province').removeClass('c_selected');
            }
        }
        var str = selected_cities.toString();
        str = str.split(',').join(', ');
        var str2 = selected_cities.toString().split(',').join(',');
        $('.search_url').attr('href', search_url + str2);
        if (str.length > 55) {
            str = str.substr(0, 50) + '...';
        }
        if (str != '') {
            $('.search_button button').text('نمایش (' + str + ')');
            $('.search_button button').css('background-color', '#2bb128');
        }
        else {
            $('.search_button button').text('نمایش');
            $('.search_button button').css('background-color', '#1289BD');
        }
    });

    $(document).on('click', '.list_province', function () {
        if (!$(this).hasClass('c_selected')) {
            $(this).parent().find('.list_city').each(function () {
                $(this).addClass('c_selected');
                var city = $(this).text().substr(0, $(this).text().lastIndexOf('(') - 1);
                if (selected_cities.lastIndexOf(city) == -1) {
                    selected_cities.push(city);
                }
            });

            $(this).addClass('c_selected');
        }
        else {
            $(this).removeClass('c_selected');
            $(this).parent().find('.list_city').each(function () {
                $(this).removeClass('c_selected');
                var index = selected_cities.lastIndexOf($(this).text().substr(0, $(this).text().lastIndexOf('(') - 1));
                selected_cities.splice(index, 1);
            });
        }
        var str = selected_cities.toString();
        str = str.split(',').join(', ');
        var str2 = selected_cities.toString().split(',').join(',');
        $('.search_url').attr('href', search_url + str2);
        if (str.length > 55) {
            str = str.substr(0, 50) + '...';
        }
        if (str != '') {
            $('.search_button button').text('نمایش (' + str + ')');
            $('.search_button button').css('background-color', '#2bb128');
        }
        else {
            $('.search_button button').text('نمایش');
            $('.search_button button').css('background-color', '#1289BD');
        }
    });
</script>
</html>
