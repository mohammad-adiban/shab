<?php use Illuminate\Support\Facades\Route;
$currentRout = Route::getFacadeRoot()->current()->uri();
?>
<html lang="fa-IR">
	<head>
		{!! SEO::generate(true) !!}
		<!-- Global Site Tag (gtag.js) - Google Analytics -->
		{{--<script async src="https://www.googletagmanager.com/gtag/js?id=UA-105149828-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments)};
		  gtag('js', new Date());

		  gtag('config', 'UA-105149828-1');
		</script> --}}
		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
					new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
				j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
				'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','GTM-NDN3DQ7');
		</script>
		<!-- End Google Tag Manager -->
		<meta charset="UTF-8">
		<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
		<meta name="rating" content="general">
		<meta name="_token" content="{{ csrf_token() }}">
		<link rel="icon" type="image/png" href="{{asset('img/favicon.ico')}}">
		<link rel="publisher" href="https://plus.google.com/109089824001381609228">
{{--			<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">--}}
		<link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/index-rtl.css?v=1.6.3') }}">
		<link type="text/css" href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet" />
		<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('js/bootstrap.js') }}" type="text/javascript"></script>
		<script src="{{ asset('js/translation.js') }}" type="text/javascript"></script>
		<script src="{{ asset('js/all.js?v=1.7.3') }}" type="text/javascript"></script>
		<script src="{{ asset('js/jquery.twbsPagination.js') }}" type="text/javascript"></script>

		<script type="text/javascript" src="{{ asset('js/gmaps.js') }}"></script>
			
			<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyDNTVTXobLWGwmhR5_NyXh8hMDYDUk-aG0&libraries=places&language=ir&region=IR"></script>
			@if ($currentRout != "/" AND $currentRout != "home")
			<script type="text/javascript">
				//	 $('body').css('overflow', 'hidden');
				//	 $('#loading').fadeIn(500);
			</script>
			@endif

			@if ($currentRout != 'houses/new' && $currentRout != 'houses/edit/{id}' && $currentRout != 'houses/show/{house}' && $currentRout != 'houses/show/{house}/temp' )
			<script type="text/javascript" src="{{ asset('js/jquery.ui.datepicker-cc.all.min.js') }}"></script>

			@endif

			<script src="{{ asset('js/jquery.easy-autocomplete.min.js') }}"></script>

			<!-- Localhost map <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=places&language=ir&region=IR"></script> -->
			
			<script type="text/javascript">
			{{--function initialize() {--}}
			{{--var options = {--}}
			{{--types: ["(regions)"],--}}
			{{--componentRestrictions: {country: "ir"}--}}
			{{--};--}}
			{{--if(window.innerWidth <= 767)--}}
			{{--var input = document.getElementById('destination-xs');--}}
			{{--else--}}
			{{--var input = document.getElementById('destination');--}}
			{{----}}
			{{--var autocomplete = new google.maps.places.Autocomplete(input , options);--}}
			{{--}--}}
			{{--// google.maps.event.addDomListener(window, 'load', initialize);--}}
			{{--</script>--}}
			{{--<script type="text/javascript">--}}
			{{--jQuery.browser = {};--}}
					{{--(function () {--}}
					{{--jQuery.browser.msie = false;--}}
					{{--jQuery.browser.version = 0;--}}
					{{--if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {--}}
					{{--jQuery.browser.msie = true;--}}
					{{--jQuery.browser.version = RegExp.$1;--}}
					{{--}--}}
					{{--})();--}}
			</script>
            <script type="text/javascript">
                    /* var LHCChatOptions = {};
                    LHCChatOptions.opt = {widget_height:340,widget_width:300,popup_height:520,popup_width:500};
                    (function() {
                    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                    var referrer = (document.referrer) ? encodeURIComponent(document.referrer.substr(document.referrer.indexOf('://')+1)) : '';
                    var location  = (document.location) ? encodeURIComponent(window.location.href.substring(window.location.protocol.length)) : '';
                    po.src = '//www.shab.ir/chat/index.php/chat/getstatus/(click)/internal/(position)/bottom_right/(ma)/br/(top)/350/(units)/pixels/(leaveamessage)/true?r='+referrer+'&l='+location;
                    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                    })(); */
            </script>
            <script type="text/javascript">
			    window.smartlook||(function(d) {
			    var o=smartlook=function(){ o.api.push(arguments)},h=d.getElementsByTagName('head')[0];
			    var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';
			    c.charset='utf-8';c.src='https://rec.getsmartlook.com/recorder.js';h.appendChild(c);
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
			{{-- @include('analyticstracking') --}}
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
			<input type="hidden" value="@if (!Auth::guest()) true @else false @endif" id="logedIn">
			
			@include('signinup')

			<nav style="padding: 0 !important"  id="header" class="navbar navbar-default @if ($currentRout != 'houses/show/{house}') navbar-fixed-top @else navbar-none-margin @endif navbar-default-customize">
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
				<div class="container-fluid container-fluid-customize" style="padding: 0 15px !important">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header navbar-header-customize">
						@if (Auth::guest())
						<button type="button" class="navbar-toggle navbar-toggle-customize navbar-header-option collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar icon-bar-customize"></span>
							<span class="icon-bar icon-bar-customize"></span>
							<span class="icon-bar icon-bar-customize"></span>
						</button>
						@else
						<div class="name-dropdown-img-container name-dropdown-img-container-mobile  navbar-toggle navbar-toggle-customize collapsed visible-xs" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
							<img src="data:image/{{getPicture()}}" />
						</div>
						@endif
						<i class="fa fa-search navbar-header-search-sign navbar-header-option visible-xs" onclick="showSearchBarMobile()" aria-hidden="true" @if($currentRout == '/') style="display:none !important" @endif></i>
						<a class="navbar-brand navbar-brand-customize" href="/"  @if($currentRout == '/') style="padding:2px" @endif><img src="{{url('/img/logo.png')}}" />
						</a>
							<div class="navbar-header-map navbar-header-option visible-xs  @if($currentRout == '/') hidden @endif" @if($currentRout == '/') style="display:none !important" @endif onclick="showCitiesList('mobile')"><img src="{{url('/img/icons/iran.png')}}" /><span>انتخاب شهرها</span></div>
					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					  
					  
					<ul class="nav navbar-nav navbar-nav-customize">	
						@if (!Auth::guest())
						<li class="dropdown name-dropdown">
							<a id="dropdown-toggle-sm" href="#" class="dropdown-toggle dropdown-toggle-customize" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}<span class="caret caret-customize"></span></a>
							<div class="name-dropdown-img-container hidden-xs" onclick="clickOnProfileImage()" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="data:image/{{getPicture()}}" /></div>
							<ul class="dropdown-menu dropdown-menu-customize hidden-xs">
								<li><a class="dropdown-menu-link" href="{{url('/dashboard')}}">پیشخوان</a></li>
								<li><a class="dropdown-menu-link hidden-lg" href="{{url('/trips')}}">سفرهای من</a></li>
								@if(Auth::user()->houses->count() != 0)
									<li><a class="dropdown-menu-link hidden-lg" href="{{url('/houses')}}">آگهی های من</a></li>
									<li><a class="dropdown-menu-link hidden-lg" href="{{url('/my_reservations')}}">رزروهای من</a></li>
								@endif
								<li><a class="dropdown-menu-link" href="{{url('/bookmarks')}}">علاقه‌مندی‌ها</a></li>
								<li><a class="dropdown-menu-link" href="{{url('/payments')}}">امور مالی</a></li>
								<li><a class="dropdown-menu-link" href="{{url('/users/edit')}}">مشخصات من</a></li>
								
								
								<li role="separator" class="divider"></li>
								<li><a  class="dropdown-menu-link" href="{{url('/logout')}}">خروج</a></li>
								<!--<li role="separator" class="divider"></li>
								<li><a href="#">One more separated link</a></li>-->
							</ul>
						</li>
						<li><a href="{{url('/dashboard')}}" class="navbar-nav-link visible-xs"><span class="navbar-nav-link-txtBox">پیشخوان</span></a></li>
						<li><a href="{{url('/trips')}}" class="navbar-nav-link visible-xs"><span class="navbar-nav-link-txtBox">سفرهای من</span></a></li>
						@if(Auth::user()->houses->count() != 0)
						<li><a href="{{url('/houses')}}" class="navbar-nav-link visible-xs"><span class="navbar-nav-link-txtBox">آگهی‌های من</span></a></li>
						<li><a href="{{url('/my_reservations')}}" class="navbar-nav-link visible-xs"><span class="navbar-nav-link-txtBox">رزروهای من</span></a></li>
						@endif
						<li><a href="{{url('/bookmarks')}}" class="navbar-nav-link visible-xs"><span class="navbar-nav-link-txtBox">علاقه‌مندی‌ها</span></a></li>
						<li><a href="{{url('/payments')}}" class="navbar-nav-link visible-xs"><span class="navbar-nav-link-txtBox">امور مالی</span></a></li>
						<li><a href="{{url('/users/edit')}}" class="navbar-nav-link visible-xs"><span class="navbar-nav-link-txtBox">مشخصات من</span></a></li>
						
						@else
						<li><a class="navbar-nav-link" style="cursor: pointer"><span class="navbar-nav-link-txtBox @if($currentRout=='login') navbar-nav-link-active @endif" data-toggle="modal" data-target="#login-modal">ورود / ثبت‌نام</span></a></li>
						@endif
						
						@if (!Auth::guest())
							<li class="visible-lg">
								<a href="/trips" class="navbar-nav-link @if($currentRout == '/') hidden @endif">
									<span class="navbar-nav-link-txtBox @if($currentRout=='trips') navbar-nav-link-active @endif ">سفرهای من</span>
								</a>
							</li>
							@if(Auth::user()->houses->count() != 0)
								<li class="visible-lg">
									<a href="/houses" class="navbar-nav-link @if($currentRout == '/') hidden @endif">
										<span class="navbar-nav-link-txtBox @if($currentRout=='houses') navbar-nav-link-active @endif ">آگهی‌های من</span>
									</a>
								</li>
								<li class="visible-lg">
									<a href="/my_reservations" class="navbar-nav-link @if($currentRout == '/') hidden @endif">
										<span class="navbar-nav-link-txtBox @if($currentRout=='my_reservations') navbar-nav-link-active @endif ">رزروهای من</span>
									</a>
								</li>
							@endif
						@endif
						<li>
							<a style="cursor: pointer" @if (Auth::guest()) data-toggle="modal" data-target="#login-modal" onclick="redirectToBehHost()"  @else href="/houses/new" @endif class="navbar-nav-link @if($currentRout == '/') hidden @endif">
								<span class="navbar-nav-link-txtBox @if($currentRout=='houses/new') navbar-nav-link-active @endif " style="color: #0faccb;">میزبان شوید</span>
							</a>
						</li>
						
						
						@if (!Auth::guest())
						<li role="separator" class="divider"></li>
						<li><a href="{{url('/logout')}}" class="navbar-nav-link visible-xs"><span class="navbar-nav-link-txtBox">خروج</span></a></li>
						@endif
					</ul>
					  
						  
					<ul class="nav navbar-nav navbar-left navbar-left-customize  @if($currentRout == '/') hidden @endif">
						<li class="hidden-xs" onclick="showCitiesList('desktop')"><a href="#" class="navbar-nav-link"><span class="navbar-nav-link-txtBox">انتخاب شهرها<span></a></li>

						<!--<li class="dropdown">
						  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
						  <ul class="dropdown-menu">
							<li><a href="#">Action</a></li>
							<li><a href="#">Another action</a></li>
							<li><a href="#">Something else here</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="#">Separated link</a></li>
						  </ul>
						</li>-->
					</ul>
					  
					  
					  <!--search form-->
					<form id="searchForm" action="/search" class="navbar-form navbar-form-customize navbar-form-customize-mobile navbar-left hidden-xs @if($currentRout == '/') hidden @endif">
						<div class="form-group form-group-customize">
							<i class="fa fa-search form-search-sign" aria-hidden="true"></i>
							<input id="destination" name="phrase" type="text" class="form-control form-control-customize" placeholder="search.title" style="padding-right: 26px !important" autocomplete="off">
							<i class="fa fa-times-circle-o form-close-sign visible-xs" onclick="hideSearchBarMobile()" aria-hidden="true"></i>
						</div>
						<!--<button type="submit" class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i></button>-->
					</form>


					</div><!-- /.navbar-collapse -->
				</div><!-- /.container-fluid -->
			</nav>
			
			<div class="list_cities list_row_city hidden-xs  @if($currentRout == '/') hidden @endif" style="display: none">
				<div class="list_mobile_close" onclick="hideCitiesList(this , 'desktop')"><i class="fa fa-close"></i></div>
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

			<div class="list_cities_mobile list_row_mobile hidden-sm hidden-md hidden-lg  @if($currentRout == '/') hidden @endif" style="display: none">
				<div class="list_mobile_close" onclick="hideCitiesList(this , 'mobile')"><i class="fa fa-close"></i></div>
				<div class="list_mobile_title"><span>انتخاب شهرها</span></div>
				<div class=" col-xs-12 box-wrapper-right box_mobile" style="overflow: scroll;">
					<div class="col-xs-6" id="mobileChooseCityColumn0"></div>
					<div class="col-xs-6" id="mobileChooseCityColumn1"></div>
				</div>
			</div>
			<div class="search_button search_button_mobile" style="display: none;">
				<a id="search_url" class="search_url" href="{{ url('/search') }}">
                    <button type="button" class="btn btn-success">نمایش همه</button>
                </a>
			</div>
			<?php $i = 0;

			$provinces = \App\House::distinct()->select('province')->bookable()->orderBy('province', 'asc')->get(); $count = 10;
			$cities = array();
			?>
			<!-- get cities from db -->

			@foreach($provinces as $province)
				<?php
				$available_cities = \App\House::distinct()->select('city')->bookable()->where('province', $province['province'])->orderBy('city', 'asc')->get();
				$cities[$province['province']] = $available_cities;
				$i = 0;
				foreach ($available_cities as $city) {
					$cities[$province['province']][$i]['count'] = \App\House::where('city', $city['city'])->bookable()->get()->count();
					$i++;
				}
				?>
			@endforeach
		</body>
	<script>		
		function showCitiesList(type) {
			if(type == "mobile") {
				$(".list_cities_mobile").slideToggle();
				$('.search_button').show();
			}
			else if(type == "desktop") {
				$(".list_cities").slideToggle();
				$('.search_button_mobile').show();
			}
			$('body').css('overflow', 'hidden');
		}
		
		function hideCitiesList(el , type) {
			if(type == "mobile") {
				$('.search_button_mobile').hide();
			}
			else if (type == "desktop") {
				$('.search_button').hide();
			}
			$(el).parent().slideToggle();
			$('body').css('overflow', 'visible');
		}

		var available_cities = <?php echo json_encode($cities); ?>;
		var i = 0;
		for (key in available_cities) {
			if ($(window).width() < 767) {
				$('#mobileChooseCityColumn'+i%2).append('<div class="col-xs-12 i_city" id="city'+i+'mobileChooseCityColumn'+i%2+'"></div>');
				$('#city'+i+'mobileChooseCityColumn'+i%2).append('<p class="list_province list_province_header">استان ' + key + '</p>');
				for (var j = 0; j < available_cities[key].length; j++) {
					$('#city'+i+'mobileChooseCityColumn'+i%2).append('<div class="col-xs-12 list_city list_city_header"><span class="chooseCity-citiesName">' + available_cities[key][j].city + '</span><span class="chooseCity-houseCount"> (' + available_cities[key][j].count + ' خانه)</span></div>');
				}       
				i++;  
			}
			else {
				$('#chooseCityColumn'+i%4).append('<div class="col-xs-12 i_city" id="city'+i+'chooseCityColumn'+i%4+'"></div>');
				$('#city'+i+'chooseCityColumn'+i%4).append('<p class="list_province list_province_header">استان ' + key + '</p>');
				for (var j = 0; j < available_cities[key].length; j++) {
					$('#city'+i+'chooseCityColumn'+i%4).append('<div class="col-xs-12 list_city list_city_header"><span class="chooseCity-citiesName">' + available_cities[key][j].city + '</span><span class="chooseCity-houseCount"> (' + available_cities[key][j].count + ' خانه)</span></div>');
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
	
		function clickOnProfileImage() {
			$("#dropdown-toggle-sm").focus();
		}
		function showSearchBarMobile() {
			if($(".navbar-collapse").hasClass("in"))
				$(".navbar-toggle-customize").click();
			$(".navbar-header-customize").html(makeSearchBarMobile());
		}
		
		function hideSearchBarMobile() {
			$(".navbar-header-customize").html(makeNavbarHeader());
		}
		function makeSearchBarMobile () {
			var txt = "";
			txt +='<form id="searchForm" action="/search" class="navbar-form navbar-form-customize navbar-form-customize-mobile navbar-right visible-xs @if($currentRout == '/') hidden @endif">';
				txt +='<div class="form-group form-group-customize">';
					txt +='<i class="fa fa-search form-search-sign" aria-hidden="true"></i>';
					txt +='<input id="destination" name="phrase" type="text" class="form-control form-control-customize" placeholder="search.title" style="padding-right: 26px !important" autocomplete="off">';
					txt +='<i class="fa fa-times-circle-o form-close-sign visible-xs" onclick="hideSearchBarMobile()" aria-hidden="true"></i>';
				txt +='</div>';
			txt +='</form>';
			
			return txt;
		}
		function makeNavbarHeader () {
			var txt = "";
			if($("#logedIn").val().trim()=="false") {
			txt +='<button type="button" class="navbar-toggle navbar-toggle-customize navbar-header-option collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">';
				txt +='<span class="sr-only">Toggle navigation</span>';
				txt +='<span class="icon-bar icon-bar-customize"></span>';
				txt +='<span class="icon-bar icon-bar-customize"></span>';
				txt +='<span class="icon-bar icon-bar-customize"></span>';
			txt +='</button>';
			}
			else {
				txt +='<div class="name-dropdown-img-container name-dropdown-img-container-mobile  navbar-toggle navbar-toggle-customize collapsed visible-xs" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">';
					txt +='<img src="data:image/{{getPicture()}}" />';
				txt +='</div>';
			}
			txt +='<i class="fa fa-search navbar-header-search-sign navbar-header-option visible-xs" @if($currentRout == '/') style="display:none !important" @endif onclick="showSearchBarMobile()" aria-hidden="true"></i>';
			txt +='<a class="navbar-brand navbar-brand-customize" href="/home"><img src="{{url('/img/logo.png')}}" /></a>';
			txt +='<div class="navbar-header-map navbar-header-option visible-xs" @if($currentRout == '/') style="display:none !important" @endif onclick="showCitiesList(\'mobile\')"><img src="{{url('/img/icons/iran.png')}}" /><span>انتخاب شهرها</span></div>';
			
			return txt;
		}
	</script>

			<script type="text/javascript">
				$("#destination").keydown(function(event) {
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

</html>