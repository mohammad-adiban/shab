<!DOCTYPE html>
<?php use Illuminate\Support\Facades\Route;
$currentRout = Route::getFacadeRoot()->current()->uri();
?>
<html lang="fa-IR">
	<head> 
		<meta charset="UTF-8">
		{!! SEO::generate(true) !!}
		<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">

		<meta name="_token" content="{{ csrf_token() }}">
		<link rel="icon"
			type="image/png"
			href="{{asset('img/favicon.ico')}}">
{{--			<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">--}}
			<link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
			<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/index-rtl.css?v=1.1') }}">
			<link type="text/css" href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet" />
			<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('js/bootstrap.js') }}" type="text/javascript"></script>
			<script src="{{ asset('js/translation.js') }}" type="text/javascript"></script>
			<script type="text/javascript" src="{{ asset('js/jquery.ui.datepicker-cc.all.min.js') }}"></script>
			<script src="{{ asset('js/all.js') }}" type="text/javascript"></script>
		<script src="{{ asset('js/jquery.twbsPagination.js') }}" type="text/javascript"></script>

		<script type="text/javascript" src="{{ asset('js/gmaps.js') }}"></script>
			
			<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDNTVTXobLWGwmhR5_NyXh8hMDYDUk-aG0&libraries=places&language=ir&region=IR"></script>
			@if ($currentRout != "/" AND $currentRout != "home")
			<script type="text/javascript">
				//	 $('body').css('overflow', 'hidden');
				//	 $('#loading').fadeIn(500);
			</script>
			@endif

			<!-- Localhost map <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=places&language=ir&region=IR"></script> -->
			
			<script type="text/javascript">
			function initialize() {
			var options = {
			types: ["(regions)"],
			componentRestrictions: {country: "ir"}
			};
			if(window.innerWidth <= 767)
			var input = document.getElementById('destination-xs');
			else
			var input = document.getElementById('destination');
			
			var autocomplete = new google.maps.places.Autocomplete(input , options);
			}
			google.maps.event.addDomListener(window, 'load', initialize);
			</script>
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
                    var LHCChatOptions = {};
                    LHCChatOptions.opt = {widget_height:340,widget_width:300,popup_height:520,popup_width:500};
                    (function() {
                    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                    var referrer = (document.referrer) ? encodeURIComponent(document.referrer.substr(document.referrer.indexOf('://')+1)) : '';
                    var location  = (document.location) ? encodeURIComponent(window.location.href.substring(window.location.protocol.length)) : '';
                    po.src = '//shab.ir/chat/index.php/chat/getstatus/(click)/internal/(position)/bottom_right/(ma)/br/(top)/350/(units)/pixels/(leaveamessage)/true?r='+referrer+'&l='+location;
                    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                    })();
            </script>
            <script type="text/javascript">
			    window.smartlook||(function(d) {
			    var o=smartlook=function(){ o.api.push(arguments)},h=d.getElementsByTagName('head')[0];
			    var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';
			    c.charset='utf-8';c.src='//rec.getsmartlook.com/recorder.js';h.appendChild(c);
			    })(document);
			    smartlook('init', 'd77a149643e0bb36360c00abbc07539afb87a036');
			</script>
			<style>
			        @media only screen and (max-width : 640px) {
				        #lhc_need_help_container {
				                display:none!important;
				        }
				        #lhc_status_container {
				                display:none!important;
				        }
			        }       
			</style>
		</head>
		<body>
			@include('analyticstracking')
			<!-- <div id="loading">
					<div id="loading-center">
							<div id="loading-center-absolute">
									<div class="object" id="object_one"></div>
									<div class="object" id="object_two"></div>
									<div class="object" id="object_three"></div>
							</div>
					</div>
			</div> -->
			<input type="hidden" value="{{ $currentRout }}" id="currentRout">
			<div id="header" class="prj-header @if ($currentRout != "/" AND $currentRout != "home") {{'white'}} @endif ">
				<nav class="navbar">
					<div class="container1 container-full1">
						<div class=" col-sm-7 navbar-header pad-l-0 pad-r-0">
							<button toggle="false" type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							</button>
							@if ($currentRout != "/" AND $currentRout != "home")
								<form action="/search">
							<!-- 		<label for="destination-xs" class="text-center col-xs-7 col-xs-offset-1-off visible-xs whereToBtn">
										<i class="fa fa-search"></i>
										<input placeholder="search.whereTo" type="text" name="des" id="destination-xs">

									</label> -->
								</form>
							@endif
							<a class="navbar-brand pad-v-3 @if ($currentRout != "/" AND $currentRout != "home") {{'hidden-xs1'}} @else {{'logo-white'}} @endif" href="/"></a>
							@if ($currentRout != "/" AND $currentRout != "home")

							<form action="/search" id="searchForm">
								<div class="col-sm-7 col-xs-6 header-search">
									<i class="fa fa-search"></i>
									<input value="@if(isset($_GET['des'])) {{ $_GET['des'] }} @endif" name="des" tag="@if(isset($_GET['des'])){{'search'}}@endif" class="whereTo" type="text" id="destination" placeholder="search.whereTo" >
									<div hidden class="h-search-settings hidden-xs">
										<div class="panel-body basic">
											<div class="setting checkin">
												<label for="header-search-checkin">
													<strong><lng key="search.checkIn"></lng></strong>
												</label>
												<input id="header-search-checkin" class="date_picker"  name="checkin">
											</div>
											<div class="setting checkout">
												<label for="header-search-checkout">
													<strong><lng key="search.checkOut"></lng></strong>
												</label>
												<input id="header-search-checkout" class="date_picker" name="checkout">
											</div>
											<div class="setting guests">
												<label for="header-search-checkin">
													<strong><lng key="search.guests"></lng></strong>
												</label>
												<select name="guests">
													@for ($i = 1; $i <= 10; $i++)
													<option value="{{$i}}">{{$i}} نفر</option>
													@endfor
												</select>
											</div>
										</div>
										<div class="panel-header">
											<small>
											<strong><lng key="search.roomType"></lng></strong>
											</small>
										</div>
										<div class="panel-body search-items">
											<label class="checkbox menu-item" for="room_type_0">
												<input type="checkbox" id="room_type_0" name="room_type" value="apartment">
												<i class="fa fa-building"></i>
												<span><lng key="search.entireHome"></lng></span>
											</label>
											<label class="checkbox menu-item" for="room_type_1">
												<input type="checkbox" id="room_type_1" name="room_type" value="private">
												<i class="fa fa-bed"></i>
												<span><lng key="search.privateRoom"></lng></span>
											</label>
											<label class="checkbox menu-item" for="room_type_2">
												<input type="checkbox" id="room_type_2" name="room_type" value="villa">
												<i class="fa fa-home"></i>
												<span><lng key="search.villa"></lng></span>
											</label>
											<button type="submit" class="btn btn-default btn-block"><i class="fa fa-search"></i><span><lng key="index.search"></lng></span></button>
										</div>
									</div>
								</div>
							</form>
							@endif
						</div>

						<div class="collapse navbar-collapse" id="myNavbar">
							
							@if ($currentRout != "/" AND $currentRout != "home")
							<?php
							$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
							$parse = parse_url($url);
							?>

							@endif
							<ul class="nav navbar-nav navbar-right">
								@if (Auth::guest())
								<li><a id="signup" href="{{ url('/register') }}"><lng key="header.signup"></lng></a></li>
								<li><a id="login" href="{{ url('/login') }}"><lng key="header.login"></lng></a></li>
								@else
								<li class="dropdown">
									<a  data-toggle="dropdown" class="dropdown-toggle" id="user" href="{{ url('/dashboard') }}">

										<div class="hidden-md hidden-sm username">{{ Auth::user()->name }}</div>
										<div class="user-pic">
											<img src="data:image/{{getPicture()}}">
										</div>
									</a>
									<ul class="dropdown-menu hidden-xs">
										<li><a class="flt-rtl text-rtl" href="{{ url('/houses') }}">پنل کاربری</a></li>
										<li><a  class="flt-rtl text-rtl" href="{{ url('/users/edit') }}">تنظیمات کاربری</a></li>
										<li><a class="flt-rtl text-rtl"  href="{{ url('/logout') }}">خروج</a></li>
									</ul>
								</li>
								<li class="dropdown">
									<a  data-toggle="dropdown" class="dropdown-toggle" id="messages" href="{{ url('/dashboard') }}">
										<i class="fa fa-envelope">
										<!-- <div class="alert-count">1</div> -->
										</i><span class="hidden-md hidden-sm">اطلاعیه ها</span>
									</a>
									<ul class="dropdown-menu hidden-xs">
										<li>
											<div class="panel-header no-border text-rtl">
												<strong>
												<span>اطلاعیه ها</span>
												<span> (</span>
												<span>0</span>
												<span>)</span>
												
												</strong>
											</div>
										</li>
										<li>
											<a href="{{ url('/dashboard') }}" class="link-reset pull-right see-all">مشاهده همه اطلاعیه ها</a>
										</li>
									</ul>
								</li>
								<li><a id="trips" href="{{ url('/trips') }}"><i class="fa fa-briefcase"></i> <span class="hidden-md  hidden-sm">سفر ها</span></a></li>
								@endif
								<li class="visible-xs"><a href="{{ url('/houses/new') }}"><lng key="header.host"></lng></a></li>
								@if (!Auth::guest())
									<li><a class="visible-xs"  href="{{ url('/logout') }}">خروج</a></li>
								@endif
								<div class="hidden-xs pull-right become-a-host">
									<a class="" href="{{ url('/houses/new') }}">
										<span class="btn btn-small">
											<lng key="header.host"></lng>
										</span>
									</a>
								</div>
							</ul>
						</div>
					</div>
				</nav>
			</div>

			<script type="text/javascript">
				$("#destination").keypress(function(event) {
				    if (event.which == 13) {
				        event.preventDefault();
				        $("#searchForm").submit();
				 }
});
			</script>

			<script>
				$(document).ready(function() {
					if(getCookie("gift_visible") != "false") {
						$(".gift").fadeIn(100);
					}

					$('#close-gift').on('click', function(e) {
						e.preventDefault();
						$(".gift").fadeOut(500);
						giftHidden();
					});
					function giftHidden() {
						setCookie("gift_visible", "false");
					}
				});
			</script>
			