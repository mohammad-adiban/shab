@include('header')
<html lang="fa" dir="rtl" style="overflow-x: hidden;">
<head>
    <meta charset="UTF-8">
    <title>اجاره ویلا در بندرانزلی - مجموعه اقامتی تفریحی چلیپا</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/persian-datepicker.css?v=1.1') }}"/>
    <link href="{{ asset('css/house_new.css?v=1.2.16') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/lightgallery.min.css') }}" type="text/css" media="screen"/>
    <script type="text/javascript" src="{{ asset('js/lightgallery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/lg-fullscreen.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/lg-thumbnail.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/lg-zoom.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/moment-jalaali.js') }}"></script>
    <script src="{{ URL::asset('js/persian-date.js') }}"></script>
    {{--    <script src="{{ URL::asset('js/persian-datepicker-0.4.5.js') }}"></script>--}}

    <link type="text/css" href="{{ asset('css/flickity.min.css') }}" rel="stylesheet"/>

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bookmarks.css?v=0.0.3') }}">


    <script src="{{ asset('js/house_new.js?v=2.0.0') }}"></script>
    <link type="text/css" href="{{ asset('css/slick.css') }}" rel="stylesheet"/>
    <link type="text/css" href="{{ asset('css/slick-theme.css') }}" rel="stylesheet"/>
    <script src="{{ URL::asset('js/slick.min.js') }}"></script>
    <link type="text/css" href="{{ asset('css/search_new.css?v=1.0') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('css/calendar.css?v=0.2.1') }}" rel="stylesheet">


</head>
<body style="overflow: visible;">
<?php
echo '<script>console.log('.$house.')</script>'
//?>
<!-- The Modal -->
<div id="bookingModal" class="bookingModal">

    <!-- Modal content -->
    <div class="bookingModal-content">
        {{--<div class="bookingModal-header">--}}
        {{--<span id="bookingModalClose" class="close">&times;</span>--}}
        {{--<h4></h4>--}}
        {{--</div>--}}
        <div class="bookingModal-body">
            {{--<div class="bookingModal-info-container">--}}
            {{--<div class="booking-info">--}}
            {{--<div>--}}
            {{--<span>هرشب از </span>--}}
            {{--<span><b>{{ $house->min_price * 1000 }}</b></span>--}}
            {{--<span><b> تومان</b></span>--}}
            {{--</div>--}}

            {{--<div>--}}
            {{--<div id="houseRating" class="star-wrapper">--}}
            {{--<span class="fa fa-star"></span>--}}
            {{--<span class="fa fa-star"></span>--}}
            {{--<span class="fa fa-star"></span>--}}
            {{--<span class="fa fa-star"></span>--}}
            {{--<span class="fa fa-star"></span>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}


            <div>
                @include('calendar')
            </div>
        </div>
        {{--<div class="modal-footer">--}}
        {{--<h3>Modal Footer</h3>--}}
        {{--</div>--}}
    </div>

</div>




<div class="container-fluid navbar-house-wrapper">
    <div class="row">
        <div id="menu-center" class="col-xs-12 navbar-house">
            <ul class="nav">
                <li class="navbar-house__item">
                    <a class="navbar-house__link" href="#pictures">تصاویر</a>
                </li>
                <li class="navbar-house__item">
                    <a class="navbar-house__link" href="#options">امکانات</a>
                </li>
                <li class="navbar-house__item">
                    <a class="navbar-house__link" href="#price">قیمت</a>
                </li>
                <li class="navbar-house__item">
                    <a class="navbar-house__link" href="#location">مکان</a>
                </li>
                <li class="navbar-house__item">
                    <a class="navbar-house__link" href="#comments">نظرات</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="col-xs-12 booking hidden-md hidden-lg">
    <div class="container">
        <div
                class="booking-container"
                style="flex-direction: column;"
        >
            {{--<div--}}
                    {{--class="booking-info"--}}
                    {{--style="width: 100%; flex-direction: row; justify-content: space-between; margin-bottom: 7px; padding: 0 5px"--}}
            {{-->--}}
                {{--<div>--}}
                    {{--<span>هرشب از </span>--}}
                    {{--<span><b>{{ $house->min_price * 1000 }}</b></span>--}}
                    {{--<span><b> تومان</b></span>--}}
                {{--</div>--}}

                {{--<div class="rating" style="margin-bottom: 0; text-align: left">--}}
                    {{--<div id="houseRatingBottom" class="star-wrapper" style="margin: 0">--}}
                        {{--<span class="fa fa-star"></span>--}}
                        {{--<span class="fa fa-star"></span>--}}
                        {{--<span class="fa fa-star"></span>--}}
                        {{--<span class="fa fa-star"></span>--}}
                        {{--<span class="fa fa-star"></span>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

            <div style="width: 100%; display: flex; justify-content: space-between; align-items: flex-end">
                <div style="width: 55%;">
                    <div style="margin-bottom: 4px">
                        <span>هرشب از </span>
                        <span><b>{{ $house->min_price * 1000 }}</b></span>
                        <span><b> تومان</b></span>
                    </div>
                <div
                        id="bookingBtn"
                        class="booking-btn"
                        style="display: flex; justify-content: center; align-items: center; text-align: center;
                        background-color: #1b6d85; margin-left: 2px; font-size: 15px"
                >درخواست رزرو</div>
                </div>


                <div style="display: flex; flex-direction: column; width: 35%">
                <a
                        href="/help/guest" target="_blank"
                        style="width: 100%; margin-bottom: 2px"
                >
                    <div
                            id="bookingBtn"
                            class="booking-btn"
                            style="width:100%; padding: 5px 10px; text-align: center; color: #E91E63; background-color: #ffffff; font-size: 12px; border: 1px solid"
                    >چطور رزرو کنم؟</div>
                </a>

                    <a
                            href="https://t.me/Javdan_F" target="_blank"
                            style="width: 100%"
                    >
                        <div
                                id="bookingBtn"
                                class="booking-btn"
                                style="width:100%; padding: 5px 10px; text-align: center; color: #03A9F4; background-color: #fff; font-size: 12px; border: 1px solid"
                        >
                            <span class="glyphicon glyphicon-send" style="top: 3px"></span>
                            <span>تلگرام پشتیبانی</span>
                        </div>
                    </a>
                </div>
                {{--<a href="https://t.me/Javdan_F" target="_blank" style="text-decoration: none">--}}
                    {{--<div style="margin-top: 5px; color: #0d3349; font-weight: 700; font-size: 12px">--}}
                        {{--<span class="glyphicon glyphicon-send" style="top: 3px"></span>--}}
                        {{--<span>تلگرام پشتیبانی رزرواسیون</span>--}}
                    {{--</div>--}}
                {{--</a>--}}
            </div>
        </div>
    </div>
</div>

<div class="container" style="padding: 0">

    <div id="pictures" class="col-xs-12 col-md-8 pictures-section-container" style="padding: 0;">
        <div class="container col-xs-12 card-view-section card-view-section-pictures" style="padding: 0;margin: 0">
            <div class="row host" style="margin: 0">
                <div style="padding: 0">
                    <?php
                    $i = 0;
                    $cover_index = 0;
                    $images = $house->photos()->get();
                    ?>
                    @foreach($images as $image)
                        <?php
                        if ($image['is_cover'] == 1) {
                            $cover_index = $i;
                        }
                        $i++;
                        ?>

                    @endforeach
                    <div class="house activeGallery"
                         style="background-image:url(/{{ $images[$cover_index]["path"] }})">
                        <p class="house__more-photos activeGallery">مشاهده تصاویر بیشتر</p>
                        @if(!isBookable($house))
                            <div class="col-xs-12"
                                 style="display:flex; justify-content: center; align-items: center; position: absolute; top: 50%; font-size: 17px;
                         font-weight: bold; height: 50px; margin-top: -25px;
                         color: #fff; background-color: rgba(155,8,0,0.56); text-align: center;">
                                <span>این اقامتگاه غیرفعال است</span>
                            </div>
                        @endif
                    </div>
                    @if (!Auth::guest())
                    <div class="item-favorite-container">
                        <div class="item-favorite">
                            <i class="fa fa-heart @if($house->bookmarked) active @endif"></i>
                            <i class="fa fa-heart-o"></i>
                        </div>
                    </div>
                    @endif
                    <ul class="lightgallery">
                        <div hidden data-src="/{{$images[$cover_index]["path"]}}">
                            {{--<img class="host-imgs" src="/{{ $imgPath }}" name="/{{$imgPath}}">--}}
                            <input class="gallery_photo" type="hidden" value="/{{$images[$cover_index]['path']}}" name="/{{$images[$cover_index]['path']}}">
                        </div>
                        @foreach($images as $image)
                            <?php $imgPath = $image['thumbnail_path'];
                            $imgPathFull = $image['path']
                            ?>
                            @if($image['path'] != $images[$cover_index]["path"])
                                <div hidden data-src="/{{$imgPathFull}}">
                                    {{--<img class="host-imgs" src="/{{ $imgPath }}" name="/{{$imgPath}}">--}}
                                    <input class="gallery_photo" type="hidden" value="/{{$imgPath}}" name="/{{$imgPath}}">
                                </div>
                            @endif
                        @endforeach
                    </ul>
                </div>

            @if(isBookable($house))
                <!--buttons in mobile-->
                    <div class="col-xs-12 btns-mobile hidden">
                        <button class="btn btn-danger register-btn-mobile visible-xs-inline-block">درخواست رزرو</button>
                        <div class="btn btn-primary share-btn-mobile visible-xs-inline-block">
                            <i class="fa fa-share-alt fa-2x"></i>
                            <a href="https://telegram.me/share/url?url=https://www.shab.ir/houses/show/{{$house->id}}" target="_blank" class="social-mobile"><i class="fa fa-2x fa-paper-plane"></i></a>
                            <a href="sms:&body=https://www.shab.ir/houses/show/{{$house->id}}" target="_blank" class="social-mobile"><i class="fa fa-2x fa-mobile"></i></a>
                            <a href="mailto:?body=https://www.shab.ir/houses/show/{{$house->id}}" target="_blank" class="social-mobile"><i class="fa fa-2x fa-envelope"></i></a>
                        </div>
                    </div>
                @endif
            </div>
            <div class="row host">
                <div class="col-xs-12 col-sm-10 col-sm-offset-2">
                    <h2 class="host__name text-left mobile-txt-picture-section">{{ $house->title }}</h2>
                </div>
                <div class="col-xs-8 col-sm-10 col-sm-push-2 mobile-txt-picture-section">
                    <div>
                        <a class="host__location text-muted text-left pull-left"
                           href="#location">{{$house->province}} @if($house->province != $house->city)
                                ، {{ $house->city }}@endif @if($house->village != '')، {{ $house->village }} @endif</a>
                        <p class="host__code text-muted">کد آگهی: {{$house->id}}</p>
                    </div>
                    <div class="rating">
                        <div id="houseRating" class="star-wrapper">
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                        </div>
                        @if($house->statistics['requests'])
                            <span>{{$house->statistics['requests']}} بار رزرو شده</span>
                        @else
                            <span>تاکنون رزرو نشده</span>
                        @endif
                    </div>
                </div>
                <div class="col-xs-3 col-sm-2 col-sm-pull-10">
                    <?php $picture = $house->user['picture']; ?>
                    <div class="host__wrapper text-center-xs">
                        <img class="host__img" height="67" width="67"
                             src="@if($picture != ''){{asset($picture)}}@else{{asset('img/user-default.png')}} @endif">
                        <p class="host__username username">{{$house->user['name']}}  {{$house->user['family']}}</p>
                    </div>
                </div>
            </div>
            <div class="row host">
                <div class="col-xs-12 house-icons">
                    <div class="col-xs-3">
                        <div class="house-icon villa"></div>
                        <p class="text-center">
                            @if($house->type =='room') سوئیت
                            @elseif($house->type =='apartment') آپارتمان
                            @else ویلایی
                            @endif
                        </p>
                    </div>
                    <div class="col-xs-3">
                        <div class="house-icon count"></div>
                        @if($house->max_accommodates > 0)
                            <p class="text-center">تا {{ $house->max_accommodates }} نفر</p>
                        @else
                            <p class="text-center">تا {{ $house->accommodates }} نفر</p>
                        @endif
                    </div>
                    <div class="col-xs-3">
                        <div class="house-icon bedroom"></div>
                        <p class="text-center">{{ $house->rooms }} اتاق</p>
                    </div>
                    <div class="col-xs-3">
                        <?php
                        $beds = $house->beds;
                        ?>
                        <div class="house-icon bed"></div>
                        <p class="text-center">@if($beds == 0) بدون تخت @else {{ $beds }} تخت @endif</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-md-4 col-md-offset-7 fixed-left-column tablet-left-column hidden-sm hidden-xs" id="left-column">
        <button class="visible-xs btn btn-default center-block close-btn-mobile">
            <i class="fa fa-close"></i>
        </button>

        <div class="book">
            <div class="book__header">
                <?php $min = $house->min_price . '000';
                $min = number_format($min, 0, '.', ',');
                ?>
                <span class="min_from">{{$house->min_price}}
                        </span>
                <span class="pull-right">هر شب</span>
            </div>

            <div class="book_body">
                @if(!isBookable($house))
                    <div style="display:flex; justify-content: center; align-items: center; font-size: 17px;
                                     font-weight: bold; height: 40px;
                                     color: #fff; background-color: rgba(155,8,0,0.56); text-align: center;">
                        <span>این اقامتگاه غیرفعال است</span>
                    </div>
                @elseif(isBookable($house))
                    {{--<div class="book__form">--}}
                    {{--<div class="row">--}}
                    {{--<div class="col-sm-4">--}}
                    {{--<label for="checkin1">--}}
                    {{--<span class="visible-lg-inline">تاریخ </span>--}}
                    {{--<span>رفت</span>--}}
                    {{--</label>--}}
                    {{--<input type="text" class="form-control datePicker" id="checkin1" placeholder=""--}}
                    {{--readonly="readonly">--}}
                    {{--<input type="hidden" id="checkin_hidden">--}}
                    {{--</div>--}}
                    {{--<div class="col-sm-4">--}}
                    {{--<label for="checkout1">--}}
                    {{--<span class="visible-lg-inline">تاریخ </span>--}}
                    {{--<span>برگشت</span>--}}
                    {{--</label>--}}
                    {{--<input type="text" class="form-control datePicker" id="checkout1" placeholder=""--}}
                    {{--readonly="readonly">--}}
                    {{--<input type="hidden" id="checkout_hidden">--}}
                    {{--</div>--}}
                    {{--<div class="col-sm-4">--}}
                    {{--<label for="guests">--}}
                    {{--<span class="visible-lg">چند نفرید؟</span>--}}
                    {{--<span class="hidden-lg">تعداد</span>--}}
                    {{--</label>--}}
                    {{--<select name="guests" id="guests" class="form-control">--}}
                    {{--@for ($i = 1; $i <= $house->max_accommodates; $i++)--}}
                    {{--<option value="{{$i}}">{{$i}}</option>--}}
                    {{--@endfor--}}
                    {{--</select>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="book__btn">--}}
                    {{--@if (Auth::guest())--}}
                    {{--<button data-toggle="modal" data-target="#login-modal" onclick="redirectToPreInvoice()" id="submitBtn-notLogin" class="btn btn-block btn-danger">درخواست رزرو</button>--}}
                    {{--@else--}}
                    {{--<button id="submitBtn" class="btn btn-block btn-danger">درخواست رزرو</button>--}}
                    {{--@endif--}}
                    {{--</div>--}}
                    {{--<div class="book__hints">--}}
                    {{--<a href="{{url('help/guest')}}">چگونه رزرو کنم ؟</a>--}}
                    {{--<a href="{{url('help/trust')}}" class="pull-right">چگونه اعتماد کنم ؟</a>--}}
                    {{--</div>--}}

                    <div>
                        @include('calendar')
                    </div>
                @endif
            </div>

        </div>

        <div class="wish-list hidden">
            <div class="wish-list__box">
                <label class="wish-list__label" for="SaveToListButton">
                    <input type="checkbox" id="SaveToListButton">
                    <div class="wish-list__text">
                        <span>افزودن به لیست علاقه‌مندی‌ها</span>
                        <span class="fa fa-heart-o wish-list__heart"></span>
                    </div>
                </label>
                <!--<p class="wish-list__info">۱۲۴۳۲ نفر این مکان را پسندیدند</p>-->
            </div>
            <p class="text-center">اشتراک گذاری با دوستان:</p>
            <div class="wish-list__social">
                <ul class="wish-list__social__ul">
                    <a href="https://telegram.me/share/url?url=https://www.shab.ir/houses/show/{{$house->id}}" target="_blank">
                        <li class="wish-list__social__item fa fa-2x fa-paper-plane"></li>
                    </a>


                    <a href="sms:;body=https://www.shab.ir/houses/show/{{$house->id}}">
                        <li class="wish-list__social__item fa fa-2x fa-mobile">
                        </li>
                    </a>

                    <a href="mailto:?body=https://www.shab.ir/houses/show/{{$house->id}}">
                        <li class="wish-list__social__item fa fa-2x fa-envelope">
                        </li>
                    </a>
                </ul>
            </div>
            <p class="wish-list__report">

                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">
                    <i class="fa fa-flag-o"></i> گزارش اشکال اگهی
                </button>
            </p>
        </div>
    </div>



    <!-- House Info -->
    <div class="container-fluid house-info col-xs-12 col-md-8">
        <div class="col-xs-12" style="padding: 0;">

            <!-- About House -->
            <div class="col-xs-12 card-view-section">
                <div class="row">
                    <div class="col-xs-12">
                        <h4 class="section-title">درباره این مکان</h4>
                    </div>
                    <div class="col-xs-12 col-md-9 col-md-offset-3">
                        <p class="text-justify">{{ $house->about }}</p>
                    </div>
                </div>
            </div>


            <div class="col-xs-12 col-md-6 col-md-offset-2 seperator"></div>


            <!-- House Options-->
            <div id="options" class="col-xs-12 card-view-section">
                <div class="row">
                    <div class="col-xs-12">
                        <h4 class="section-title">امکانات</h4>
                    </div>
                    <div class="col-xs-12 col-md-9 col-md-offset-3">
                        <div class="col-xs-6 option-icon">
                            <img class="furnrn icons" src="{{asset('img/icons/furn.png')}}">
                            <span class="option-title @if(!$house->furniture){{'inactive'}}@endif">مبلمان</span>
                        </div>
                        <div class="col-xs-6 option-icon">
                            <img class="cool1ol2 icons" src="{{asset('img/icons/cool1.png')}}">
                            <span class="option-title @if(!$house->water_cooling){{'inactive'}}@endif">کولر آبی</span>
                        </div>
                        <div class="col-xs-6 option-icon">
                            <img class="wififi icons" src="{{asset('img/icons/wifi.png')}}">
                            <span class="option-title @if(!$house->internet){{'inactive'}}@endif">اینترنت وایرلس</span>
                        </div>
                        <div class="col-xs-6 option-icon">
                            <img class="cool2ol1 icons" src="{{asset('img/icons/cool2.png')}}">
                            <span class="option-title @if(!$house->split_cooling){{'inactive'}}@endif">کولر گازی</span>
                        </div>
                        <div class="col-xs-6 option-icon">
                            <img class="elevatorevator icons" src="{{asset('img/icons/elevator.png')}}">
                            <span class="option-title @if(!$house->elevator){{'inactive'}}@endif">آسانسور</span>
                        </div>
                        <div class="col-xs-6 option-icon">
                            <img class="parkingrking icons" src="{{asset('img/icons/parking.png')}}">
                            <span class="option-title @if(!$house->parking){{'inactive'}}@endif">پارکینگ</span>
                        </div>
                        <div class="col-xs-6 option-icon">
                            <img class="poolol icons" src="{{asset('img/icons/pool.png')}}">
                            <span id="indoorPool" class="option-title @if(!$house->indoor_pool){{'inactive'}}@endif">استخر سرپوشیده</span>
                        </div>

                        <div class="col-xs-6 option-icon">
                            <img class="poolol icons" src="{{asset('img/icons/pool.png')}}">
                            <span class="option-title @if(!$house->outdoor_pool){{'inactive'}}@endif">استخر سرباز</span>
                        </div>
                        <div class="col-xs-6 option-icon">
                            <img class="lbreakfastreakfast icons" src="{{asset('img/icons/lbreakfast.png')}}">
                            <span class="option-title @if(!$house->bathroom){{'inactive'}}@endif">حمام</span>
                        </div>
                        <div class="col-xs-6 option-icon">
                            <img class="barbrb icons" src="{{asset('img/icons/barb.png')}}">
                            <span class="option-title @if(!$house->barbecue){{'inactive'}}@endif">باربیکیو</span>
                        </div>
                        <div class="col-xs-6 option-icon">
                            <img class="bikeke icons" src="{{asset('img/icons/tv.png')}}">
                            <span class="option-title @if(!$house->receiver){{'inactive'}}@endif">گیرنده دیجیتال</span>
                        </div>
                        <div class="col-xs-6 option-icon">
                            <img class="heatat icons" src="{{asset('img/icons/heat.png')}}">
                            <span class="option-title @if(!$house->heating){{'inactive'}}@endif">گرمایش</span>
                        </div>
                        <div class="col-xs-6 option-icon">
                            <img class="kitchentchen icons" src="{{asset('img/icons/kitchen.png')}}">
                            <span class="option-title @if(!$house->kitchen_equipment){{'inactive'}}@endif">تجهیزات آشپزی</span>
                        </div>
                        <div class="col-xs-6 option-icon">
                            <img class="breakfasteen icons" src="{{asset('img/icons/breakfast.png')}}">
                            <span class="option-title @if(!$house->breakfast){{'inactive'}}@endif">صبحانه</span>
                        </div>
                    <!-- <div class="col-xs-6 option-icon">
                            <img class="green" src="{{asset('img/icons/green.png')}}">
                            <span class="option-title @if(!$house->furniture){{'inactive'}}@endif">فضای سبز</span>
                        </div> -->
                        <div class="col-xs-6 option-icon">
                            <img class="tv icons" src="{{asset('img/icons/tv.png')}}">
                            <span class="option-title @if(!$house->television){{'inactive'}}@endif">تلویزیون</span>
                        </div>
                        <div class="col-xs-6 option-icon">
                            <img class="tr icons" src="{{asset('img/icons/tr.png')}}">
                            <span class="option-title @if(!$house->balcony){{'inactive'}}@endif">تراس</span>
                        </div>
                        <div class="col-xs-6 option-icon">
                            <img class="wc icons" src="{{asset('img/icons/wc.png')}}  ">
                            <span class="option-title @if(!$house->european_wc){{'inactive'}}@endif">سرویس فرنگی</span>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 description-card-view-section">
                    <div class="row">
                        <div class="col-xs-12">
                            <span class="title-description-card-view-section"> توضیحات </span>
                        </div>
                        <div class="col-xs-12 col-md-9 col-md-offset-3">
                            <p>{{ $house->description }}</p>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-xs-12 col-md-6 col-md-offset-2 seperator"></div>


            <!--House Price-->
            <div id="price" class="col-xs-12 card-view-section">
                <div class="row">
                    <div class="col-xs-12">
                        <h4 class="section-title">قیمت خانه</h4>
                        <?php
                        $min = $house->min_price;
                        $med = $house->median_price;
                        $max = $house->max_price;
                        $extra = $house->extra_person;
                        ?>
                    </div>
                    <div class="col-xs-12 col-md-9 col-md-offset-3">
                        <p>
								<span class="subtitle-price-section">
									<span>روزهای وسط هفته</span>
									<span class="text-muted font-sm">(شنبه تا سه‌شنبه)</span>
                                </span>
                            <strong class="pull-right price p_min">{{ $min }}</strong>
                        </p>
                        <p class="center-offset">
								<span class="subtitle-price-section">
									<span>روزهای آخر هفته</span>
									<span class="text-muted font-sm">(چهارشنبه تا جمعه)</span>
								</span>
                            <strong class="pull-right price p_med">{{ $med }}</strong>
                        </p>
                        <p>
								<span class="subtitle-price-section">
									<span>ایام پیک سال</span>
									<span class="text-muted font-sm">(تعطیلات خاص)</span>
								</span>
                            <strong class="pull-right price p_max">{{ $max }}</strong>
                        </p>
                        <p class="center-offset">
								<span class="subtitle-price-section">
									<span>نفر اضافه</span>
									<span class="text-muted font-sm">(هر نفر)</span>
                                </span>
                            <strong class="pull-right price p_extra">{{ $extra }}</strong>
                        </p>
                        @if ($house->discount_days_level1 > 0)
                            <p class="center-offset">
                                <span class="subtitle-price-section">
                                    <span>تخفیف کوتاه مدت</span>
                                    <span class="text-muted font-sm">(بالای {{ $house->discount_days_level1 }} روز)</span>
                                </span>
                                <strong class="pull-right price">%{{ $house->discount_rate_level1 }}</strong>
                            </p>
                        @endif
                        @if ($house->discount_days_level2 > 0)
                            <p class="center-offset">
                                <span class="subtitle-price-section">
                                    <span>تخفیف بلند مدت</span>
                                    <span class="text-muted font-sm">(بالای {{ $house->discount_days_level2 }} روز)</span>
                                </span>
                                <strong class="pull-right price">%{{ $house->discount_rate_level2 }}</strong>
                            </p>
                        @endif
                        <div class="table-responsive hidden">
                            <table class="table table-striped table-price">
                                <tbody>
                                <tr>
                                    <td><span>شنبه شب تا سه شنبه شب (وسط هفته)</span></td>
                                    <td><strong class="p_min1">{{ $min }}</strong></td>
                                </tr>
                                <tr>
                                    <td><span>چهارشنبه شب تا جمعه شب (آخر هفته)</span></td>
                                    <td><strong class="p_med1">{{ $med }}</strong></td>
                                </tr>
                                <tr>
                                    <td><span>تعطیلات نوروز و ایام شلوغ سال (ایام پیک)</span></td>
                                    <td><strong class="p_max1">{{ $max }}</strong></td>
                                </tr>

                                <tr>
                                    <td><span>نفر اضافه</span></td>
                                    <td><strong class="p_extra1">{{ $extra }}</strong></td>
                                </tr>
                                <tr>
                                    <td><span>تخفیف</span></td>
                                    <td><strong>@if($house->discount_days_level1 > 0) بالای {{$house->discount_days_level1}}
                                            روز {{$house->discount_rate_level1}} درصد @elseif($house->discount_days_level2 > 0) بالای {{$house->discount_days_level1}} روز {{$house->discount_rate_level1}} درصد @else ندارد @endif</strong>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        @if ($house->price_desc != '')
                            <div class="center-offset">
                                <span class="text-muted">توضیحات: </span>
                                <p class="text-justify">{{ $house->price_desc }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>


            <div class="col-xs-12 col-md-6 col-md-offset-2 seperator"></div>


            <!--House Features-->
            <div class="col-xs-12 card-view-section">
                <div class="row">
                    <div class="col-xs-12">
                        <h4 class="section-title">فضای خانه</h4>
                    </div>
                    <div class="col-xs-12 col-md-9 col-md-offset-3">
                        <div class="row">
                            <div class="col-xs-6">
                                <span class="text-muted"> متراژ زمین:</span>
                                <span class="bold">{{$house->land_area}} متر</span>
                            </div>
                            <div class="col-xs-6">
                                <span class="text-muted">متراژ بنا: </span>
                                <span class="bold">{{$house->building_area}} متر</span>
                            </div>
                            <div class="col-xs-6">
                                <span class="text-muted">تیپ سازه: </span>
                                <?php
                                $structure = $house->structure;
                                if ($structure == 'flat')
                                    $structure = 'هم‌سطح';
                                else if ($structure == 'duplex')
                                    $structure = 'دوبلکس';
                                else
                                    $structure = 'تریبلکس';

                                ?>
                                <span class="bold">{{$structure}}</span>
                            </div>

                            @if($house->type == 'apartment')
                                <div class="col-xs-6">
                                    <span class="text-muted">تعداد طبقات: </span>
                                    <span class="bold">{{$house->floors}} </span>
                                </div>

                                <div class="col-xs-6">
                                    <span class="text-muted">طبقه واحد: </span>
                                    <span class="bold">{{$house->floor_no}}</span>
                                </div>
                            @endif

                            <div class="col-xs-6">
                                <span class="text-muted">تعداد اتاق خواب: </span>
                                @if($house->rooms > 0)
                                    <span class="bold">{{$house->rooms}}</span>
                                @else
                                    <span class="bold">بدون اتاق</span>
                                @endif
                            </div>
                            {{--<div class="col-xs-6">--}}
                            {{--<span class="text-muted">نوع محل: </span>--}}
                            {{--<span class="bold">دربست</span>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xs-12 col-md-6 col-md-offset-2 seperator"></div>


            <!-- House Accommodates -->
            <div class="col-xs-12 card-view-section">
                <div class="row">
                    <div class="col-xs-12">
                        <h4 class="section-title">ظرفیت</h4>
                    </div>
                    <div class="col-xs-12 col-md-9 col-md-offset-3">
                        <div class="row">
                            <div class="col-xs-6">
                                <span class="text-muted"> ظرفیت استاندارد:</span>
                                <span class="bold">{{$house->accommodates}} نفر</span>
                            </div>
                            <div class="col-xs-6">
                                <span class="text-muted">حداکثر ظرفیت: </span>
                                <span class="bold">{{$house->max_accommodates}} نفر</span>
                            </div>

                            <div class="col-xs-6">
                                <span class="text-muted">تعداد تخت یک نفره: </span>
                                @if($house->single_beds > 0)
                                    <span class="bold">{{$house->single_beds}} تخت</span>
                                @else
                                    <span class="bold">ندارد</span>
                                @endif
                            </div>

                            <div class="col-xs-6">
                                <span class="text-muted">تعداد تخت دو نفره: </span>
                                @if($house->double_beds > 0)
                                    <span class="bold">{{$house->double_beds}} تخت</span>
                                @else
                                    <span class="bold">ندارد</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xs-12 col-md-6 col-md-offset-2 seperator"></div>


            <!--House Rules-->
            <div class="col-xs-12 card-view-section">
                <div class="row">
                    <div class="col-xs-12">
                        <h4 class="section-title">قوانین خانه</h4>
                    </div>
                    <div class="col-xs-12 col-md-9 col-md-offset-3">
                        <div class="row">
                            <div class="col-xs-6 enterTime-item-rule-section">
                                <span class="text-muted">ساعت ورود از: </span>
                                <?php
                                $checkin = $house->rule_checkin;
                                $checkout = $house->rule_checkout;
                                if ($checkin != 0) {
                                    $hours_in = floor($checkin / 60);
                                    $mins_in = $checkin % 60;
                                    if ($mins_in == 0) {
                                        $mins_in = '00';
                                    }
                                } else {
                                    $hours_in = '12';
                                    $mins_in = '00';
                                }
                                if ($checkout != 0) {
                                    $hours_out = floor($checkout / 60);
                                    $mins_out = $checkout % 60;
                                    if ($mins_out == 0) {
                                        $mins_out = '00';
                                    }
                                } else {
                                    $hours_out = '14';
                                    $mins_out = '00';
                                }

                                if (strlen($mins_in) == 1) {
                                    $mins_in = '0' . $mins_in;
                                }
                                if (strlen($mins_out) == 1) {
                                    $mins_out = '0' . $mins_out;
                                }
                                if (strlen($hours_in) == 1) {
                                    $hours_in = '0' . $hours_in;
                                }
                                if (strlen($hours_out) == 1) {
                                    $hours_out = '0' . $hours_out;
                                }
                                ?>
                                <span class="bold">{{$hours_in}}:{{$mins_in}} </span>
                            </div>
                            <div class="col-xs-6 exitTime-item-rule-section">
                                <span class="text-muted">ساعت خروج تا: </span>
                                <span class="bold">{{$hours_out}}:{{$mins_out}}</span>
                            </div>
                            <div class="col-xs-6 item-rules-section" style="padding-left: 3px">
                                <span class="text-muted">امکان ورود حیوانات خانگی: <span class="bold">@if($house->rule_pets)
                                            دارد@else ندارد @endif</span></span>
                            </div>
                            <div class="col-xs-6 item-rules-section">
                                <span class="text-muted">امکان برگزاری مراسم: <span class="bold">@if($house->rule_cermony)
                                            دارد@else ندارد @endif</span></span>
                            </div>

                            <div class="col-xs-6 item-rules-section">
                                <span class="text-muted">حداقل تعداد روز رزرو: </span>
                                <span class="bold">{{$house->rule_minimum_days}} روز</span>
                            </div>
                            <div class="col-xs-12 item-rules-section">
                                <span class="text-muted">قوانین لغو رزرو: </span>
                                <br>
                                <span class="bold">- بیش از ۴۸ساعت مانده به شروع اقامت: بازگشت کل مبلغ ودیعه بدون کسر هیچ مبلغی</span>
                                <br>
                                <span class="bold">- کمتر از ۴۸ساعت مانده به شروع اقامت: کسر مبلغ ۴۸ساعت رزرو از لحظه اعلام لغو و بازگشت باقیمانده وجه</span>
                            </div>
                            @if ($house->rules_desc != '')
                                <div class="col-xs-12">
                                    <span class="text-muted">توضیحات: </span>
                                    <p class="text-justify">{{ $house->rules_desc }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xs-12 col-md-6 col-md-offset-2 seperator"></div>


            <!-- House Type -->
            <div class="col-xs-12 card-view-section">
                <div class="row" style="margin: 0">
                    <div class="col-xs-12">
                        <div class="row">
                            <h4 class="section-title">نوع محل</h4>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-9 col-md-offset-3">
                        <div class="row1">
                            <div class="row">
                                <div class="title-description-card-view-section"> نوع محل:</div>

                                <span class="col-xs-4 col-sm-3 type-loc @if($house->private_yard)type-loc-true @else type-loc-false @endif">حیاط در اختیار</span>
                                <span class="col-xs-4 col-sm-3 type-loc @if($house->shared_yard)type-loc-true @else type-loc-false @endif">حیاط مشترک</span>
                                <span class="col-xs-4 col-sm-3 type-loc @if($house->in_complex)type-loc-true @else type-loc-false @endif">داخل شهرک</span>
                                <span class="col-xs-4 col-sm-3 type-loc @if($house->detached)type-loc-true @else type-loc-false @endif">دربست</span>
                                <span class="col-xs-4 col-sm-3 type-loc @if($house->janitor)type-loc-true @else type-loc-false @endif">سرایداری</span>
                            </div>
                            <br>
                            <div class="row">
                                <div class="title-description-card-view-section"> نوع بافت:</div>
                                <span class="col-xs-4 col-sm-3 type-loc @if($house->forest)type-loc-true @else type-loc-false @endif">جنگلی</span>
                                <span class="col-xs-4 col-sm-3 type-loc @if($house->mountain)type-loc-true @else type-loc-false @endif">کوهستانی</span>
                                <span class="col-xs-4 col-sm-3 type-loc @if($house->desert)type-loc-true @else type-loc-false @endif">کویری</span>
                                <span class="col-xs-4 col-sm-3 type-loc @if($house->coastal)type-loc-true @else type-loc-false @endif">ساحلی</span>
                                <span class="col-xs-4 col-sm-3 type-loc @if($house->in_town)type-loc-true @else type-loc-false @endif">درون شهری</span>
                                <span class="col-xs-4 col-sm-3 type-loc @if($house->historic)type-loc-true @else type-loc-false @endif">بنای تاریخی</span>
                                <span class="col-xs-4 col-sm-3 type-loc @if($house->rural)type-loc-true @else type-loc-false @endif">روستایی</span>
                                <span class="col-xs-4 col-sm-3 type-loc @if($house->summer)type-loc-true @else type-loc-false @endif">ییلاقی</span>
                                <br/>
                                @if ($house->place_desc != '')
                                    <div>
                                        <span class="text-muted">توضیحات: </span>
                                        <p class="text-justify">{{ $house->place_desc }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xs-12 col-md-6 col-md-offset-2 seperator"></div>


            <!--Reviews-->
            <div id="review-container" class="col-xs-12 card-view-section" style="display: none">
                <div class="col-xs-12">
                    <div class="row" style="display: flex; align-items: center  ">
                        <div>
                            <h4 class="section-title" style="margin: 0">
                                <span id="review-count"></span>
                                <span> بازخورد</span>
                            </h4>
                        </div>
                        <div>
                            <div class="review-rating">
                                <div class="rating text-center-xs">
                                    <div id="general-review" class="star-wrapper">
                                        <span class="fa fa-star fa-2x"></span>
                                        <span class="fa fa-star fa-2x"></span>
                                        <span class="fa fa-star fa-2x"></span>
                                        <span class="fa fa-star fa-2x"></span>
                                        <span class="fa fa-star fa-2x"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 review-seperator"></div>
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-12 col-sm-5">
                            <div class="review-rating rating-group">
                                <div class="rating text-center-xs">
                                    <span class="review-float-right">سهولت دسترسی</span>
                                    <div id="accessibility-review" class="star-wrapper">
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-5 col-sm-offset-2">
                            <div class="review-rating rating-group">
                                <div class="rating text-center-xs">
                                    <span class="review-float-right">نظافت</span>
                                    <div id="cleanliness-review" class="star-wrapper">
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-5">
                            <div class="review-rating rating-group">
                                <div class="rating text-center-xs">
                                    <span class="review-float-right">ارزش نسبت به قیمت</span>
                                    <div id="value-review" class="star-wrapper">
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-5 col-sm-offset-2">
                            <div class="review-rating rating-group">
                                <div class="rating text-center-xs">
                                    <span class="review-float-right">تطابق مشخصات</span>
                                    <div id="accuracy-review" class="star-wrapper">
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-5">
                            <div class="review-rating rating-group">
                                <div class="rating text-center-xs">
                                    <span class="review-float-right">محیط اطراف</span>
                                    <div id="neighborhood-review" class="star-wrapper">
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-5 col-sm-offset-2">
                            <div class="review-rating rating-group">
                                <div class="rating text-center-xs">
                                    <span class="review-float-right">کیفیت میزبانی</span>
                                    <div id="host-review" class="star-wrapper">
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="comments" class="row">
                    <div class="col-xs-12">
                        <h4 class="section-title"></h4>
                    </div>
                    <div class="col-xs-12" id="commentContainer">

                        <!-- <div class="pagination">
                            <div class="pagination__pages">
                                <ul class="pagination__pages__list">
                                    <li class="pagination__page__item caret-right">
                                        <a href="#/" class="pagination__page__link fa fa-caret-right disabled"></a>
                                    </li>
                                    <li class="pagination__page__item">
                                        <a href="#/" class="pagination__page__link selected">1</a>
                                    </li>
                                    <li class="pagination__page__item">
                                        <a href="#/" class="pagination__page__link">2</a>
                                    </li>
                                    <li class="pagination__page__item">
                                        <a href="#/" class="pagination__page__link">3</a>
                                    </li>
                                    <li class="pagination__page__item">...</li>
                                    <li class="pagination__page__item">
                                        <a href="#/" class="pagination__page__link">8</a>
                                    </li>
                                    <li class="pagination__page__item caret-left">
                                        <a href="#/" class="pagination__page__link fa fa-caret-left"></a>
                                    </li>
                                </ul>
                            </div>
                            <p class="pagination__text">این خونه خیلی باحاله</p>
                            <a class="pagination__more">بیشتر</a>
                        </div> -->
                    </div>
                </div>
            </div>





            <!--location-->
            <div id="location" class="col-xs-12" style="margin-top: 30px">
                <div class="row">
                    <div class="col-xs-12">
                        <div id="neighborhood" style="height: 400px !important; margin: 0"></div>
                    </div>
                </div>
            </div>


            <div class="col-xs-12 col-md-6 col-md-offset-2 seperator"></div>

        </div>
    </div>

    <!--ویلاهای مشابه-->
    <div id="similar-container" class="col-xs-12" style="margin-bottom: 40px">
        <div class="suggestion mg-t-2">
            <div class="row" style="margin: 0">
                <div class="col-xs-12" style="padding: 0">
                    <div class="pull-left title picture-suggestion" style="padding: 0">ویلاهای مشابه</div>
                    <hr>
                </div>
            </div>
        </div>
        <div
                id="similar-carousel"
                class="similar-galery js-flickity"
                data-flickity-options='{ "freeScroll": "true", "wrapAround": "true", "pageDots": "false" }'
        >
        </div>
    </div>
</div>


<input id="ruleMinimumDays" value={{$house->rule_minimum_days}} hidden/>
<input id="houseIdCalendar" value={{$house->id}} hidden/>
<input id="minPrice" value={{$house->min_price}} hidden/>
<input id="medianPrice" value={{$house->median_price}} hidden/>
<input id="maxPrice" value={{$house->max_price}} hidden/>
<input id="isHousePage" value="0" hidden />


<div class="house_id" style="display:none">{{$house->id}}</div>
<script src="{{ asset('js/flickity.pkgd.min.js') }}" type="text/javascript"></script>
<script>
                $(document).ready(function () {
        statisticsRequest();

        reviewsRequest();

        $.ajax({
            type: "POST",
            url: "/houses/{{ $house->id }}/similars",
            success: function(res) {
                var houses = res;
                if(houses.length === 0) {
                    $('#similar-container').css('display', 'none');
                }
                else {
                    var $carousel = $('#similar-carousel').flickity();
                    for (var i = 0; i < houses.length; i++) {
                        var price = priceToReadable(houses[i].min_price);
                        var type = houseType(houses[i].type);
                        var $cellElems = $(houseItemMaker(houses[i], true, "{{Auth::guest()}}", 0));
                        $carousel.flickity('prepend', $cellElems);
                    }
                    $carousel.flickity('select', 0);
                    configHouse();
                }

            }
        });

        makeJsonScript();
    });



    $('.slider_default').css('visibility', 'visible');

    function houseType(type) {
        if (type == 'villa')
            return 'ویلایی';
        else if (type == 'room')
            return 'سوییت';
        else
            return 'آپارتمان';
    }

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
                        infinite: false
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: false
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: false
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
            if (nextSlide == lastSlide + 1) {
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


    var map;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -34.397, lng: 150.644},
            zoom: 8,
            scrollwheel: false
        });
    }



    //Statistics Request
    function statisticsRequest() {
        var average = 0;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var formData = {

        };

        $.ajax({
            type: "POST",
            url: "/houses/{{  $house->id }}/statistics",
            data: formData,
            success: function (data) {
                if(data) {
                    $('#review-container').css('display', '');
                    $('#review-count').html(data.reviews);
                    average = (data.accessibility + data.cleanliness + data.value + data.accuracy + data.neighborhood + data.host) / 6;
                    fillRateStars(average, 'houseRating');
                    fillRateStars(average, 'general-review');
                    fillRateStars(average, 'houseRatingBottom');
                    fillRateStars(data.accessibility, 'accessibility-review');
                    fillRateStars(data.cleanliness, 'cleanliness-review');
                    fillRateStars(data.value, 'value-review');
                    fillRateStars(data.accuracy, 'accuracy-review');
                    fillRateStars(data.neighborhood, 'neighborhood-review');
                    fillRateStars(data.host, 'host-review');
                }
            },
            error: function (data) {

            }
        });
    }

    function fillRateStars(rate, containerID) {
        rate = Math.round(rate);
        for(var i=1 ; i <= rate ; i++) {
            $('#'+containerID+' > span:nth-child('+i+')').addClass('checked');
        }
    }

    //Reviews Request
    function reviewsRequest() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var formData = {

        };

        $.ajax({
            type: "POST",
            url: "/houses/{{  $house->id }}/reviews",
            data: formData,
            success: function (result) {
                if(result.data.length === 0) {

                }
                else {
                    $("#commentContainer").empty();
                    $("#comments").css("display", "");
                    for(var i=0; i<result.data.length; i++)
                    {
                        $("#commentContainer").append(makeCommentFn(result.data[i]));
                    }
                    $(".comment:last-child").css("border" , "none");
                }
            },
            error: function (data) {

            }
        });
    }
</script>

<form method="get" style="display:none" id="payform" action="{{url('/houses/reserve/'.$house->id)}}">
    <input type="hidden" id="arrivalCalendar" name="checkin">
    <input type="hidden" id="departureCalendar" name="checkout">
    <input type="hidden" id="accomodatesCalendar" name="accomodates" value="1">
    <input type="submit" name="">
</form>
@extends('footer')
</body>
</html>
<script type="text/javascript">
    var map;
    map = new GMaps({
        el: '#neighborhood',
        lat: 35.76752801,
        lng: 51.37678955,
        zoomControl: true,
        zoomControlOpt: {
            style: 'SMALL',
            position: 'TOP_LEFT'
        },
        panControl: false,
        streetViewControl: false,
        mapTypeControl: false,
        overviewMapControl: false,
        scrollwheel: false,
        navigationControl: false,
        mapTypeControl: false,
        scaleControl: false,
        draggable: true,
    });
    // var markers = [];
    poi_marker = {
        lat: '{{ $house->latitude }}',
        lng: '{{ $house->longitude }}',
        fillColor: '#FF0000',
        strokeColor: '#FF0000',
        radius: 300,
        strokeWeight: 1,
    }
    // markers.push(poi_marker);
    // map.addMarkers(markers);
    map.drawCircle(poi_marker);

    // GMaps.geolocate({
    //   success: function(position) {
    map.setCenter('{{ $house->latitude }}', '{{ $house->longitude }}');
    //  },
    // });
    map.setZoom(15);
</script>
@if (session('status') == 'OK')
    <?php echo "<script type='text/javascript'>
                    $(document).ready(function(){
                        alert('درخواست رزرو شما با موفقیت در سایت شب ثبت گردید. پس از اعلام وضعیت توسط میزبان، نتیجه درخواست از طریق پیامک به اطلاع شما خواهد رسید')
                    })
                </script>"; ?>
@endif


<script src="{{ asset('js/bookmarks.js?v=0.0.4') }}" type="text/javascript"></script>

<script>
    function makeCommentFn (comment) {
        var txt = '';
        moment.loadPersian({dialect: 'persian-modern'});
        var c_date = moment.unix(comment.checkin);
        c_date = digitsToHindi(c_date.format('jMMMM jYYYY'));

//        if(comment.parent_id != "0") {
//            $('#commentID_'+comment.parent_id).append(makeReplyCommentFn(comment));
//            return ;
//        }
        txt += '<div class="comment" id="commentID_'+comment.id+'">';
        txt += '<div class="comment__avatar">';
        if(comment.picture !== '')
            txt += '<img src="/'+comment.picture+'" class="comment__img">';
        else
            txt += '<img src="https://www.shab.ir/img/user-default.png" class="comment__img">';
        txt += '</div>';
        txt += '<div class="info">';
        txt += '<div class="comment__username">'+comment.name+ " " + comment.family+'</div>';
        txt += '<div class="comment__date">'+c_date+'</div>';
        txt += '</div>';
        //  txt += '<div class="report">';
        //      txt += '<a class="report__link"><i class="fa fa-flag"></i>گزارش</a>';
        //      txt += '<a href="#/" class="like">';
        //          txt += '<i class="fa fa-thumbs-o-up fa-flip-horizontal like__hand"></i>';
        //          txt += '<span class="like__title">لایک</span>';
        //          txt += '<span class="like__count">2</span>';
        //      txt += '</a>';
        //  txt += '</div>';
        txt += '<p class="comment__text">'+comment.description+'</p>';
        txt += '</div>';

        return txt;
    }

    function makeReplyCommentFn (replyComment) {
        var txt = '';
        var c_date = replyComment.created_at;
        c_date = moment(c_date, 'YYYY/MM/DD');
        c_date = digitsToHindi(c_date.format('jYYYY/jMM/jDD'));

        txt += '<div class="comment reply" id="commentID_'+replyComment.id+'">';
        txt += '<div class="comment__avatar">';
        if(comment.picture != '')
            txt += '<img src="'+comment.picture+'" class="comment__img">';
        else
            txt += '<img src="https://www.shab.ir/img/user-default.png" class="comment__img">';
        txt += '</div>';
        txt += '<div class="info">';
        txt += '<div class="comment__username">'+replyComment.name+'</div>';
        txt += '<div class="comment__date">'+c_date+'</div>';
        txt += '</div>';
        txt += '<p class="comment__text">'+replyComment.comment+'</p>';
        txt += '</div>';

        return txt;
    }


    function makeJsonScript() {
        var statistics = '{{$house->statistics}}';
        if(statistics) {
            var average = (statistics['accessibility'] + statistics['cleanliness'] + statistics['value'] + statistics['accuracy']  + statistics['neighborhood']  + statistics['host']) / 6;
            var el = document.createElement('script');
            el.type = 'application/ld+json';
            el.text = JSON.stringify({
                "@context": "http://schema.org/",
                "@type": "Product",
                "name": $('title').html(),
                "image": [
                    "/{{ $images[$cover_index]['path']}}"
                ],
                "description": $('meta[name="description"]').attr('content'),
                "brand": {
                    "@type": "Thing",
                    "name": "SHAB"
                },
                "aggregateRating": {
                    "@type": "AggregateRating",
                    "ratingValue": average,
                    "ratingCount": statistics['reviews']
                }
            });

            document.querySelector('head').appendChild(el);
        }
    }


    // Get the modal
    var modal = document.getElementById('bookingModal');

    // Get the button that opens the modal
    var btn = document.getElementById("bookingBtn");

    // When the user clicks the button, open the modal
    btn.onclick = function() {
        modal.style.display = "flex";
    };

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };

    $('#bookingModalClose').click(function(event) {
        modal.style.display = "none";
    });

    var maxAccommodates = parseInt("{{$house->max_accommodates}}");
    var accommodates = parseInt("{{$house->accommodates}}");
    var guestCount =  $('.guestsCount');

    var bookmarked = parseInt('{{$house->bookmarked}}');
    $('.item-favorite-container').click(function (e) {
        e.preventDefault();
        if(bookmarked) {
            $.ajax({
                type: "POST",
                url: "/bookmarks/{{$house->id}}/delete",
                success: function (data) {

                    if (data.status === 'success') {
                        $('.item-favorite > .fa-heart').removeClass('active');
                        bookmarked = false;
                    }
                },
                error: function (data) {

                }
            });
        } else {
            $.ajax({
                type: "POST",
                url: "/houses/{{$house->id}}/bookmark",
                success: function (data) {

                    if (data.status === 'success') {
                        $('.item-favorite > .fa-heart').addClass('active');
                        bookmarked = true;
                    }
                },
                error: function (data) {

                }
            });
        }
    })
</script>

<script type="text/javascript" src="{{ asset('js/calendar-min.js?v=0.2.1') }}"></script>
