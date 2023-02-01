@include('header')
<script src="{{ asset('js/nouislider.js') }}"></script>
            <link href="{{ asset('css/nouislider.css') }}" rel="stylesheet">
            
<script type="text/javascript">
$(function() {
    var params = objFromUrl();
    USER.getSearchItems(objFromUrl(), 1);
});
</script>
<section class="s5">
    <div class="mg-top">
        <div class="col-sm-7 search-sidebar pad-l-sm-0"> <!-- sidebar -->
        <div class="col-xs-12 panel-body date">
            <div class="row">
                <div class="col-lg-2 col-md-12 text-center-sm text-center-md pad-l-0">
                    <label><lng key="search.date"></lng></label>
                </div>
                <form class="col-lg-9 trip-form flt-rtl">
                    <div class="row row-condensed">
                        <div class="col-xs-4 row-space-1-sm">
                            <input tag="search" tag="search" value="@if(isset($_GET['checkin']) && $_GET['checkin'] != '') {{ $_GET['checkin'] }} @endif" class="form-control" name="checkin" type="text" id="checkinResult" autocomplete="off" placeholder="search.checkIn" >
                        </div>
                        <div class="col-xs-4 row-space-1-sm">
                            <input tag="search" value="@if(isset($_GET['checkout']) && $_GET['checkout'] != '') {{ $_GET['checkout'] }} @endif" type="text"class="form-control" name="checkout" id="checkoutResult" autocomplete="off" placeholder="search.checkOut" >
                            
                        </div>
                        <div class="col-xs-4  row-space-1-sm">
                            <div class="select select-block">
                                <select tag="search" value="@if(isset($_GET['guests'])) {{ $_GET['guests'] }} @endif" name="guests" class="form-control" id="guest-select">
                                    @for ($i = 1; $i <= 16; $i++)
                                       <option @if(isset($_GET['guests']) && $i == $_GET['guests']) {{ 'selected' }} @endif value="{{ $i }}">{{ $i }} نفر</option>
                                    @endfor

                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-xs-12 panel-body type">
            <div class="row">
                <div class="col-lg-2 col-md-12 text-center-sm text-center-md pad-l-0">
                    <label><lng key="search.roomType"></lng></label>
                </div>
                <div class="col-lg-9">
                    <div class="row row-condensed" id="room-options">

                        <div class="col-sm-4  col-xs-8  col-sm-offset-0 col-xs-offset-2 row-space-1-sm">
                            <label class="checkbox facet-checkbox checkbox--room-type panel panel-dark" for="room-type-3">
                                <div class="icon-col">
                                    <i class="fa fa-home"></i>
                                </div>
                                <div class="label-col">
                                    <span><lng key="search.villa"></lng></span>
                                </div>
                                <div class="input-col">
                                    <input tag="search" id="room-type-3" type="checkbox" name="room_type" value="villa">
                                </div>
                            </label>
                        </div>
                        <div class="col-sm-4 col-xs-8 col-sm-offset-0 col-xs-offset-2 row-space-1-sm ">
                            <label class="checkbox facet-checkbox checkbox--room-type panel panel-dark" for="room-type-1">
                                <div class="icon-col">
                                    <i class="fa fa-home"></i>
                                </div>
                                <div class="label-col">
                                    <span><lng key="search.entireHome"></lng></span>
                                </div>
                                <div class="input-col">
                                    <input tag="search" id="room-type-1" type="checkbox" name="room_type" value="apartment">
                                </div>
                            </label>
                        </div>

                        <div class="col-sm-4  col-xs-8  col-sm-offset-0 col-xs-offset-2 row-space-1-sm">
                            <label class="checkbox facet-checkbox checkbox--room-type panel panel-dark" for="room-type-2">
                                <div class="icon-col">
                                    <i class="fa fa-home"></i>
                                </div>
                                <div class="label-col">
                                    <span><lng key="search.privateRoom"></lng></span>
                                </div>
                                <div class="input-col">
                                    <input tag="search" id="room-type-2" type="checkbox" name="room_type" value="room">
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 panel-body">
            <div class="row">
                <div class="col-lg-2 col-md-12 text-center-sm text-center-md pad-l-0">
                    <label><lng key="search.priceRange"></lng></label>
                </div>
                <div class="col-lg-9 col-xs-10 col-lg-offset-0 col-xs-offset-1 ">
                    <div class="row row-slider" id="price-slider5"></div> <!-- range slider -->
                    <div class="avg-price">
                    <!--    <small>
                        <span class="price"> 300 </span>
                        <span><lng key="search.currency"></lng></span>
                        <span> میانگین</span>
                        </small> -->
                    </div>
                    <div class="row">
                        <div class="col-xs-6 flt-rtl-always range" id="start-point">1</div>
                        <div class="col-xs-6 text-right range" id="end-point">1000</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 panel-body filters-section">
            <div class="row">
                <div class="col-lg-2 col-md-12 text-center-sm text-center-md pad-l-0">
                    <label><lng key="search.size"></lng></label>
                </div>
                <div class="col-lg-9 col-xs-12 flt-rtl">
                    <div class="row row-condensed">
                        <div class="col-md-4 col-xs-6 row-space-1-sm">
                            <div class="select select-block">
                                <select tag="search" name="bedroom_count" class="form-control" id="guest-select">
                                    <option value="remove">اتاق خواب</option>
                                    @for ($i = 1; $i < 10; $i++)
                                       <option value="{{$i}}">{{$i}} خواب</option>
                                    @endfor
                                    <option value="10">+‌۱۰  خواب</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-6  row-space-1-sm">
                            <div class="select select-block">
                                <select tag="search" name="bed_count" class="form-control" id="guest-select">
                                    <option value="remove">تخت</option>
                                    @for ($i = 1; $i < 16; $i++)
                                       <option value="{{$i}}">{{$i}} تخت</option>
                                    @endfor
                                    <option value="16">+‌۱۶  تخت</option>

                                </select>
                            </div>
                        </div>
                        {{--<div class="col-md-3 col-xs-6  row-space-1-sm">--}}
                            {{--<div class="select select-block">--}}
                                {{--<select tag="search" name="floors_count" class="form-control" id="guest-select">--}}
                                    {{--<option value="remove">تعداد طبقات</option>--}}
                                    {{--@for ($i = 1; $i <= 5; $i++)--}}
                                       {{--<option value="{{$i}}">{{$i}} طبقه</option>--}}
                                    {{--@endfor--}}
                                {{--</select>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="col-md-4 col-xs-12  row-space-1-sm">
                            <div class="select select-block">
                                <select tag="search" name="area_type" class="form-control" id="guest-select">
                                    <option value="remove">نوع محل</option>
                                       <option value="detached">دربست</option>
                                       <option value="in_complex">داخل شهرک</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 panel-body filters-section">
            <div class="row">
                    <div class="col-sm-1 showMore">
                        <label class="show-more" data-toggle="collapse" data-target=".collapse-filter">
                            <span>
                                <i class="fa fa-caret-down"></i>
                                 <span>فیلترها</span>
                            </span>
                        </label>
                    </div>
                <div class="col-lg-2 col-sm-11 pad-l-0">
                    <label><lng key="search.amenities"></lng></label>
                </div>
                <div class="col-lg-9 col-md-9 col-xs-11 col-lg-offset-0 col-md-offset-2 col-xs-offset-1">
                    <div class="row row-condensed labels ">
                    </div>
                    <div class="filters-more collapse collapse-filter">

                        <div class="row row-condensed filters-columns">

                            <div class="col-xs-4 row-space-1-sm">
                                <label title="Wireless Internet">
                                    <div>
                                        <input tag="search" type="checkbox" name="amenities" value="internet">
                                    </div>
                                    <div><span>اینترنت وایرلس</span></div>
                                </label>
                            </div>
                            <div class="col-xs-4  row-space-1-sm">
                                <label title="Pool">
                                    <div>
                                        <input tag="search" type="checkbox" name="amenities" value="pool">
                                    </div>
                                    <div><span>استخر</span></div>
                                </label>
                            </div>
                            <div class="col-xs-4  row-space-1-sm">
                                <label title="Kitchen">
                                    <div>
                                        <input tag="search" type="checkbox" name="amenities" value="barbecue">
                                    </div>
                                    <div><span>باربیکیو</span></div>
                                </label>
                            </div>

                            <div class="col-xs-4  row-space-1-sm">
                                <label title="Pool">
                                    <div>
                                        <input tag="search" type="checkbox" name="amenities" value="heating">
                                    </div>
                                    <div><span>گرمایش</span></div>
                                </label>
                            </div>
                            <div class="col-xs-4  row-space-1-sm">
                                <label title="Pool">
                                    <div>
                                        <input tag="search" type="checkbox" name="amenities" value="water_cooling">
                                    </div>
                                    <div><span>کولر آبی</span></div>
                                </label>
                            </div>
                            <div class="col-xs-4  row-space-1-sm">
                                <label title="Pool">
                                    <div>
                                        <input tag="search" type="checkbox" name="amenities" value="split_cooling">
                                    </div>
                                    <div><span>کولر گازی</span></div>
                                </label>
                            </div>
                            <div class="col-xs-4  row-space-1-sm">
                                <label title="Pool">
                                    <div>
                                        <input tag="search" type="checkbox" name="amenities" value="breakfast">
                                    </div>
                                    <div><span>صبحانه</span></div>
                                </label>
                            </div>
                            <div class="col-xs-4  row-space-1-sm">
                                <label title="Pool">
                                    <div>
                                        <input tag="search" type="checkbox" name="amenities" value="television">
                                    </div>
                                    <div><span>تلویزیون</span></div>
                                </label>
                            </div>
                            <div class="col-xs-4  row-space-1-sm">
                                <label title="Pool">
                                    <div>
                                        <input tag="search" type="checkbox" name="amenities" value="parking">
                                    </div>
                                    <div><span>پارکینگ</span></div>
                                </label>
                            </div>
                            <div class="col-xs-4  row-space-1-sm">
                                <label title="Pool">
                                    <div>
                                        <input tag="search" type="checkbox" name="amenities" value="local_breakfast">
                                    </div>
                                    <div><span>صبحانه محلی</span></div>
                                </label>
                            </div>
                            <div class="col-xs-4  row-space-1-sm">
                                <label title="Pool">
                                    <div>
                                        <input tag="search" type="checkbox" name="amenities" value="elevator">
                                    </div>
                                    <div><span>آسانسور</span></div>
                                </label>
                            </div>
                            <div class="col-xs-4  row-space-1-sm">
                                <label title="Pool">
                                    <div>
                                        <input tag="search" type="checkbox" name="amenities" value="furniture">
                                    </div>
                                    <div><span>مبلمان</span></div>
                                </label>
                            </div>
                            <div class="col-xs-4  row-space-1-sm">
                                <label title="Pool">
                                    <div>
                                        <input tag="search" type="checkbox" name="amenities" value="bicycle">
                                    </div>
                                    <div><span>دوچرخه</span></div>
                                </label>
                            </div>
                            <div class="col-xs-4  row-space-1-sm">
                                <label title="Pool">
                                    <div>
                                        <input tag="search" type="checkbox" name="amenities" value="european_wc">
                                    </div>
                                    <div><span>سرویس فرنگی</span></div>
                                </label>
                            </div>
                            <div class="col-xs-4  row-space-1-sm">
                                <label title="Pool">
                                    <div>
                                        <input tag="search" type="checkbox" name="amenities" value="kitchen_equipment">
                                    </div>
                                    <div><span>تجهیزات آشپزی</span></div>
                                </label>
                            </div>
                            <div class="col-xs-4  row-space-1-sm">
                                <label title="Pool">
                                    <div>
                                        <input tag="search" type="checkbox" name="amenities" value="green_space">
                                    </div>
                                    <div><span>فضای سبز</span></div>
                                </label>
                            </div>
                            <div class="col-xs-4  row-space-1-sm">
                                <label title="Pool">
                                    <div>
                                        <input tag="search" type="checkbox" name="amenities" value="balcony">
                                    </div>
                                    <div><span>تراس</span></div>
                                </label>
                            </div>
                        </div>
                        </div> <!-- more filters -->
                    </div>

                </div>
            <button class="visible-xs btn col-xs-10 col-xs-offset-1 btn-default top-6">جستجو</button>

            </div>
            <div class="col-sm-12 search-result pad-xs-0">
                <span class="slength fx-span text-left pad-v-1"></span>
                <div class="col-sm-12 result-description">
                    <span><lng key="search.description"></lng></span>
                </div>
                <div class="search-result-list-container">
                    <div class="s-list">
                        <div class="row">

                        
        
    </div>
</div>
</div>
                        
                        <div style="display: none;" id="searchItemTemplate">
                            <div class="col-sm-6 col-sm-offset-0 col-xs-8 col-xs-offset-2 list-item"> <!-- search result item -->
                            <div id="item-id" class="item-main">
                                <img src="" class="fullImg">
                                <a href="" target="_blank" id="item-a" class="item-desc">
                                    <!-- <div class="item-like">
                                        <i class="fa fa-heart"></i>
                                        <i class="fa fa-heart-o"></i>
                                    </div> -->
                                    <div class="col-xs-1 slidesec slide-left">
                                        <div class="icon-center text-center">
                                            <div class="slide left"></div>
                                            <div class="slide left leftdown"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-1 slidesec slide-right">
                                        <div class="icon-center text-center">
                                            <div class="slide rightdown"></div>
                                            <div class="slide rightup"></div>
                                        </div>
                                    </div>
                                    <div class="load-spinner"></div>
                                    <div class="item-price">
                                        <span id="item-price" class="priceReadable"></span>
                                        <!-- <small><lng key="search.currency"></lng></small> -->
                                    <!--    <small class="gray"><lng key="search.perMonth"></lng></small> -->
                                    </div>
                                </a>
                                
                            </div>
                            <div class="panel-body panel-card-section">
                                <div class="media">
                                    <a href="#" class="media-photo-badge pull-right card-profile-picture">
                                        <div class="media-photo media-round">
                                            <img class="userImg" src="{{ asset('img/user-default.png') }}">
                                        </div>
                                    </a>
                                    <div class="item-info">
                                        <span>
                                            <a id="item-a" target="_blank" href="">
                                                <h4 id="item-title"></h4>
                                                <span id="item-type" style="float: left;font-size: 14px;"></span>
                                                <div style="visibility: hidden;" class="star-rating">
                                                    <div class="foreground">
                                                        <i class="fa fa-star star-1"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </div>
                                                    <div class="background">
                                                        <i class="fa fa-star "></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star star-0"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </div>
                                                </div>
                                                <span style="visibility: hidden;" id="reviewCount">۰</span><span  style="visibility: hidden;"> <lng key="search.review"></lng></span>
                                                
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

<input type="hidden" name="Search" tag="search">

<div class="results-footer">

<div class="search-page-buttons">
    <div class="results-count">
        <p class="items-count text-left"><span id="firstItem"></span> - <span id="lastItem"></span> از <span id="itemsCount"></span> نتیجه</p>
    </div>
    <div class="paginate">
        <ul class="list-unstyled">
            {{--<li class="active">--}}
                {{--<a rel="start" target="1" href="#">1</a>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<a rel="next" target="2" href="#">2</a>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<a target="3" href="#">3</a>--}}
            {{--</li>--}}
            {{--<li class="gap"><span class="gap">…</span></li>--}}
            {{--<li>--}}
                {{--<a target="17" href="#">17</a>--}}
            {{--</li>--}}
            {{--<li class="next next_page">--}}
                {{--<a target="2" rel="next" href="/s/spain?page=2">--}}
                    {{--<span class="screen-reader-only">Next</span>--}}
                    {{--<i class="fa fa-caret-right"></i>--}}
                {{--</a>--}}
            {{--</li>--}}
        </ul>
    </div>
</div>
<!-- <div class="nearby-links">

    <lng key="search.morePlaces"></lng> <span id="search-title"> </span> :
    <a class="text-muted" href="/s/Spain?type=apartment">آپارتمان</a> ·
    <a class="text-muted" href="/s/Spain?type=house">
        خانه
    </a> ·
    <a class="text-muted" href="/s/Spain?type=bnb">
        صبحانه
    </a> ·
    <a class="text-muted" href="/s/Spain?type=loft">
        ویلا
    </a>

    <div class="space-top-1">
        <lng key="search.peopleAlsoStay"></lng>
          <a class="text-muted" href="#">
            تهران
        </a> ·
        <a class="text-muted" href="#">
            مشهد
        </a> ·
        <a class="text-muted" href="#">
            شیراز
        </a> ·
        <a class="text-muted" href="#">
            اصفهان
        </a>
    </div>
</div> -->
</div>
</div>
</div>
<div class="col-sm-5 hidden-xs map" style="z-index: 0;" id="map"></div> <!-- map -->
</div>
</section>

<div class="visible-xs">
</div>

<script type="text/javascript">
    var slider = document.getElementById('price-slider5');
    noUiSlider.create(slider, {
        start: [10, 2000],
        connect: true,
        step: 5,
        range: {
            'min': 10,
            'max': 2000
        }
    });
    slider.noUiSlider.on('update', function( values, handle ) {
        var value = values[handle].split('.')[0];
        if ( !handle ) { // must change it back to if(handle). did it for rtl. must read lang from cookie.
            var currency = ' هزار تومان';
            if(value > 999) {
                value = value/1000;
                currency = ' میلیون تومان';
            }
            $("#end-point").text(value + currency); //end point
            traverse($("#end-point")[0]);

        } else {
            var currency = ' هزار تومان';
            if(value > 999) {
                value = value/1000;
                currency = ' میلیون تومان';
            }
            $("#start-point").text(value + currency); //start point
            traverse($("#start-point")[0]);
            
        }
});
    slider.noUiSlider.on('change', function( values, handle ) { 
                var value = values[handle].split('.')[0];
        if ( !handle ) { 
                if(issetUrlParam('price_min')) {
                    updateUrlParam('price_min', encodeURIComponent(value));
                }
                else {
                    setUrlParam('price_min', encodeURIComponent(value));
                }
        } else {
                if(issetUrlParam('price_max')) {
                    updateUrlParam('price_max', encodeURIComponent(value));
                }
                else {
                    setUrlParam('price_max', encodeURIComponent(value));
                }
        }

        $('#guest-select').trigger("change");
    });
</script>
<script type="text/javascript">
var geocoder =  new google.maps.Geocoder();
    var loc = "<?php if(isset($_GET['des'])) Print($_GET['des']); else Print(''); ?>";
    var lat, lng;
    showResults = false;
    if(loc == '' || loc == ' ') {
                showResults = true;
                lat = 33.578014746143985;
                lng = 52.62451171875;
                map = new GMaps({
                    el: '#map',
                    lat: lat,
                    lng: lng,
                    zoomControl : false,
                    zoomControlOpt: {
                        style : 'SMALL',
                        position: 'TOP_LEFT'
                    },
                    panControl : false,
                    streetViewControl : false,
                    mapTypeControl: false,
                    overviewMapControl: false
                });
                map.setZoom(5);
    }
    else {
    geocoder.geocode( { 'address': loc+', ir'}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        showResults = true;
        lat = results[0].geometry.location.lat();
        lng = results[0].geometry.location.lng(); 
        map = new GMaps({
          el: '#map',
          lat: lat,
          lng: lng,
          zoomControl : false,
          zoomControlOpt: {
              style : 'SMALL',
              position: 'TOP_LEFT'
          },
          panControl : false,
          streetViewControl : false,
          mapTypeControl: false,
          overviewMapControl: false
        });
        map.setZoom(5);
      }
    });
        }

//var topofDiv = $(".slength").offset().top; //gets offset of header
//var height = $(".slength").outerHeight();
//
//$(".search-sidebar").bind('scroll', function() {
//  if($(window).scrollTop() > (topofDiv + height)){
//      console.log(1);
//  }
//  else{
//      console.log(0);
//  }});

var fixmeTop = $('.slength').offset().top;       // get initial position of the element

$(".search-sidebar").bind('scroll', function() {
    var currentScroll = $(".search-sidebar").scrollTop(); // get current position

    if (currentScroll >= fixmeTop - 55) {           // apply position: fixed if you
        $('.slength').addClass('fx-span-active');
        $('.showMore').addClass('fx-btn-active');
        $('body').css('overflow', 'hidden');
        $('.search-page-buttons').css('margin-bottom', '100px');
    } else {                                   // apply position: static
        $('.slength').removeClass('fx-span-active');
        $('.showMore').removeClass('fx-btn-active');


    }

});

$(".showMore").click(function() {
    $(".search-sidebar").animate({
                scrollTop: 200},
            'slow');
});


// GMaps.geolocate({
//   success: function(position) {
//     map.setCenter(position.coords.latitude, position.coords.longitude);
//   },
//   error: function(error) {
//     alert('Geolocation failed: '+error.message);
//   },
//   not_supported: function() {
//     alert("Your browser does not support geolocation");
//   },
//   always: function() {
//   }
// });
</script>