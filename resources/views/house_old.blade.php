@include('header_old')

<script type="text/javascript" src="{{ asset('js/jquery.easing.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/moment-jalaali.js') }}"></script>

<link rel="stylesheet" href="{{ asset('css/lightgallery.min.css') }}" type="text/css" media="screen" />
<script type="text/javascript" src="{{ asset('js/lightgallery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/lg-fullscreen.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/lg-thumbnail.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/lg-zoom.min.js') }}"></script>





<div class="button_book_info col-xs-10 col-xs-offset-1 down-3" style="display:none">
    <div class="close-slider close_book"><i class="fa fa-close"></i></div>
    <div class="col-xs-12 flt-rtl top-3">
        <div class="col-xs-12"><label for="start_xs">تاریخ رفت</label></div>
        <div class="col-xs-12"><input value="@if(isset($_GET['checkin'])){{$_GET['checkin']}} @endif" type="text" name="start_xs" class="form-control"></div>
    </div>
    <div class="col-xs-12 top-3">
        <div class="col-xs-12"><label for="end_xs">تاریخ برگشت</label></div>
        <div class="col-xs-12"><input value="@if(isset($_GET['checkout'])){{$_GET['checkout']}} @endif" type="text" name="end_xs" class="form-control"></div>
    </div>
    <div class="col-xs-12 down-3 top-3">
        <div class="col-xs-6 col-xs-offset-3">
            <p>چند نفرید؟</p>
            <input class="form-control" name="guests_xs" type="number" />
        {{--     <select  name="count_xs" class="count_book">
                @for ($i = 1; $i <= 10; $i++)
                    <option @if(isset($_GET['guests']) && $_GET['guests'] == $i) selected @endif value="{{$i}}">{{$i}} نفر</option>
                @endfor
            </select> --}}
        </div>
    </div>
    <div class="col-xs-12 down-3 mg-t-3">
        <button class="col-xs-8 col-xs-offset-2 btn btn-danger submitBtn">ثبت درخواست</button>
    </div>
</div>


<div class="room-content">


    <div class="button_book col-xs-12 hidden-lg hidden-sm hidden-md">
        <button class="btn btn-danger">ثبت درخواست</button>
    </div>
    <div class="subnav">
        <div class="container">
            <div class="col-sm-10 col-sm-offset-1">
                <ul class="list-unstyled">
                    <li>
                        <a id="photos1" href="#photos" class="subnav-item scroll">تصاویر</a>
                    </li>
                    <li>
                        <a id="summary1" href="#summary" class="subnav-item scroll">درباره خانه</a>
                    </li>
                    <!--    <li>
                        <a id="reviews1" href="#reviews" class="subnav-item scroll">نقد و بررسی</a>
                    </li>
                    <li>
                        <a id="host1" href="#host" class="subnav-item scroll">میزبان شما</a>
                    </li> -->
                    <li>
                        <a id="neighborhood1" href="#neighborhood" class="subnav-item scroll">مکان خانه</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="photos" class="with-photos">
        <div class="cover-img activeLightgallery" >
            <?php $img = $house->photos()->get()->first()["path"];
            ?>
            <div class="host-imgs-top lightgallery" style="background-image:url(/{{$img}});  background-position: 50%; background-repeat: no-repeat; background-size: 100%">
            </div>
                <div class="allImages hidden-lg hidden-md hidden-sm" style="width:100%;position: absolute;top:190px;text-align:center"><p style="font-size:17px">مشاهده عکس های بیشتر</p></div>
        </div>

    </div>
    <div class="col-md-4 book_it col-sm-8 col-md-offset-0 col-sm-offset-2 hidden-xs">
        <div class="book-it">
            <div class="book-it__container ">
                <div class="book-it__price">
                    <div class="row">
                        <div class="col-sm-8 text-left">
                            <div class="book-price">
                                <span class="h5 priceReadable" price="{{ $house->min_price }}"></span> (<i class="info-l fa fa-question questionHover">
                                </i>)
                            </div>
                        </div>
                        <div class="col-sm-4 text-left">
                            <div class="book-period">
                                <span>هر شب</span>
                            </div>
                        </div>
                    </div>
                </div>
                <form id="reqform">
                    <div class="book-it-panel panel-body">
                        <div class="row ">
                            <div class="col-sm-4 pad-03">
                                <p>تاریخ رفت</p>
                                <input name="checkin_lg" id="checkin" value="@if(isset($_GET['checkin'])){{$_GET['checkin']}} @endif" type="text" class="form-control date_picker">
                            </div>
                            <div class="col-sm-4 pad-03">
                                <p>تاریخ برگشت</p>
                                <input name="checkout_lg" value="@if(isset($_GET['checkout'])){{$_GET['checkout']}} @endif" type="text" id="checkout" class="form-control date_picker">
                            </div>
                            <div class="col-sm-4 pad-03">
                                <p>چند نفرید؟</p>
                                {{-- <select name="count" class="count">
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option @if(isset($_GET['guests']) && $_GET['guests'] == $i) selected @endif value="{{$i}}">{{$i}} نفر</option>
                                    @endfor
                                </select> --}}
                            <input value="@if(isset($_GET['guests'])){{ $_GET['guests'] }}@endif" class="form-control" name="guests" type="number" />

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <input type="button" class="btn btn-danger submitBtn" value="ثبت درخواست">
                            </div>
                        </div>
                        <a href="{{url('/help/guest')}}" class="col-xs-6 mg-t-1">چگونه رزرو کنم؟</a>
                        <a href="{{url('/help/trust')}}" class="col-xs-6 mg-t-1">چگونه اعتماد کنم؟</a>
                    </div>
                </form>
            </div>
        </div>
    </div>  <div id="summary" class="col-xs-12 summary">
        <div class="col-md-8 col-xs-12 col-md-offset-1 mg-b-7--">
            <div class="summary-component">
                <div class="space-4 space-top-4">
                    <div class="row">
                        <div class="col-sm-8 col-xs-12 mg-d-1">
                            <a class="media-photo media-round pad-l-0 pad-r-0  " href="#">
                                <?php $picture = $house->user['picture']; ?>
                                <img class="host-img" height="67" width="67" src="@if($picture != ''){{asset($picture)}}@else{{asset('img/user-default.png')}} @endif">
                            </a>
                            <p class="username">{{$house->user['name']}}  {{$house->user['family']}}</p>

                            <h2 class="text-left col-xs-offset-1 col-sm-8 col-xs-6">{{ $house->title }}</h2>
                            <div id="display-address " class="space-2 col-xs-6 col-xs-offset-1">
                                <a class="text-muted text-left" href="#location">{{$house->province}} @if($house->province != $house->city)، {{ $house->city }}@endif</a>
                                <p class="text-muted">کد آگهی:‌ {{$house->id}}</p>
                            </div>
                        </div>

                        <div class="col-sm-9 col-sm-offset-2 address ">

                            <div class="text-muted text-center">
                                <div class="col-xs-3">
                                    <div class="icon-house" style="background-image: url({{asset('img/icons/villa.png')}})"></div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="icon-house" style="background-image: url({{asset('img/icons/count.png')}})"></div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="icon-house" style="background-image: url({{asset('img/icons/bedroom.png')}})"></div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="icon-house" style="background-image: url({{asset('img/icons/bed.png')}})"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 hidden-xs text-center">
                            <a href="#332233">{{ $house->owner }}</a>
                        </div>
                        <div class="col-sm-9 col-sm-offset-2 text-center">
                            <div class="col-xs-3 house-type">
                                @if($house->type =='room') سوئیت
                                @elseif($house->type =='apartment') آپارتمان
                                @else ویلا
                                @endif
                            </div>
                            <div class="col-xs-3 ">{{ $house->accommodates }} نفر</div>
                            <div class="col-xs-3 ">{{ $house->rooms }} اتاق خواب</div>
                            <div class="col-xs-3 ">{{ $house->beds }} تخت</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-row col-sm-10 col-sm-offset-1">

        <div class="details col-md-12 col-md-offset-off" id="details">
            <div class="row col-md-8 col-md-offet-2">
                <div class="col-md-12">
                    <div class="space-8 space-top-8 col-md-12">
                        <h3 class="space-4">
                            درباره این مکان
                        </h3>
                        <div class="about space-4 w-wrap">
                            {{ $house->about }}
                        </div>
                        <!-- <button class="btn btn-default">تماس با میزبان</button> -->
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                امکانات
                            </div>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="space col-sm-12 col-xs-6">
                                            <img class="icons-img" src="{{asset('img/icons/furn.png')}}">
                                            @if($house->furniture)
                                                <strong class="green">مبلمان</strong>
                                            @else
                                                <s>مبلمان</s>
                                            @endif
                                        </div>

                                        <div class="space col-sm-12 col-xs-6">
                                            <img class="icons-img" src="{{asset('img/icons/wifi.png')}}">
                                            @if($house->internet)
                                                <strong class="green">اینترنت وایرلس</strong>
                                            @else
                                                <s>اینترنت وایرلس</s>
                                            @endif
                                        </div>

                                        <div class="space col-sm-12 col-xs-6">
                                            <img class="icons-img" src="{{asset('img/icons/elevator.png')}}">
                                            @if($house->elevator)
                                                <strong class="green">آسانسور</strong>
                                            @else
                                                <s>آسانسور</s>
                                            @endif
                                        </div>

                                        <div class="space col-sm-12 col-xs-6">
                                            <img class="icons-img" src="{{asset('img/icons/pool.png')}}">
                                            @if($house->pool)
                                                <strong class="green">استخر</strong>
                                            @else
                                                <s>استخر</s>
                                            @endif
                                        </div>

                                        <div class="space col-sm-12 col-xs-6">
                                            <img class="icons-img" src="{{asset('img/icons/barb.png')}}">
                                            @if($house->barbecue)
                                                <strong class="green">باربیکیو</strong>
                                            @else
                                                <s>باربیکیو</s>
                                            @endif
                                        </div>

                                        <div class="space col-sm-12 col-xs-6">
                                            <img class="icons-img" src="{{asset('img/icons/heat.png')}}">
                                            @if($house->heating)
                                                <strong class="green">گرمایش</strong>
                                            @else
                                                <s>گرمایش</s>
                                            @endif
                                        </div>

                                        <div class="space col-sm-12 col-xs-6">
                                            <img class="icons-img" src="{{asset('img/icons/breakfast.png')}}">
                                            @if($house->breakfast)
                                                <strong class="green">صبحانه</strong>
                                            @else
                                                <s>صبحانه</s>
                                            @endif
                                        </div>

                                        <div class="space col-sm-12 col-xs-6">
                                            <img class="icons-img" src="{{asset('img/icons/tv.png')}}">
                                            @if($house->television)
                                                <strong class="green">تلویزیون</strong>
                                            @else
                                                <s>تلویزیون</s>
                                            @endif
                                        </div>

                                        <div class="space col-sm-12 col-xs-6">
                                            <img class="icons-img" src="{{asset('img/icons/wc.png')}}">
                                            @if($house->european_wc)
                                                <strong class="green">سرویس فرنگی</strong>
                                            @else
                                                <s>سرویس فرنگی</s>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="col-sm-6">
                                        <div class="space col-sm-12 col-xs-6">
                                            <img class="icons-img" src="{{asset('img/icons/cool2.png')}}">
                                            @if($house->water_cooling)
                                                <strong class="green">کولر آبی</strong>
                                        @else
                                            <s>کولر آبی</s>
                                            @endif

                                        </div>


                                        <div class="space col-sm-12 col-xs-6">
                                            <img class="icons-img" src="{{asset('img/icons/cool1.png')}}">
                                            @if($house->split_cooling)
                                                <strong class="green">کولر گازی</strong>
                                            @else
                                                <s>کولر گازی</s>
                                            @endif
                                        </div>

                                        <div class="space col-sm-12 col-xs-6">
                                            <img class="icons-img" src="{{asset('img/icons/parking.png')}}">
                                            @if($house->parking)
                                                <strong class="green">پارکینگ</strong>
                                            @else
                                                <s>پارکینگ</s>
                                            @endif
                                        </div>

                                        <div class="space col-sm-12 col-xs-6">
                                            <img class="icons-img" src="{{asset('img/icons/lbreakfast.png')}}">
                                            @if($house->local_breakfast)
                                                <strong class="green">صبحانه محلی</strong>
                                            @else
                                                <s>صبحانه محلی</s>
                                            @endif
                                        </div>

                                        <div class="space col-sm-12 col-xs-6">
                                            <img class="icons-img" src="{{asset('img/icons/bike.png')}}">
                                            @if($house->bicycle)
                                                <strong class="green">دوچرخه</strong>
                                            @else
                                                <s>دوچرخه</s>
                                            @endif
                                        </div>

                                        <div class="space col-sm-12 col-xs-6">
                                            <img class="icons-img" src="{{asset('img/icons/kitchen.png')}}">
                                            @if($house->kitchen_equipment)
                                                <strong class="green">تجهیزات آشپزی</strong>
                                            @else
                                                <s>تجهیزات آشپزی</s>
                                            @endif
                                        </div>

                                        <div class="space col-sm-12 col-xs-6">
                                            <img class="icons-img" src="{{asset('img/icons/green.png')}}">
                                            @if($house->green_space)
                                                <strong class="green">فضای سبز</strong>
                                            @else
                                                <s>فضای سبز</s>
                                            @endif
                                        </div>

                                        <div class="space col-sm-12 col-xs-6">
                                            <img class="icons-img" src="{{asset('img/icons/tr.png')}}">
                                            @if($house->balcony)
                                                <strong class="green">تراس</strong>
                                            @else
                                                <s>تراس</s>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3 space-1">
                            فضای خانه
                        </div>
                        <div class="space col-sm-3 col-xs-9 col-sm-offset-0 col-xs-offset-3 space-1">
                            <strong class="">متراژ زمین: {{$house->land_area}} متر </strong>
                        </div>
                        <div class="space col-sm-3 col-xs-9 col-sm-offset-0  col-xs-offset-3 space-1">
                            <strong class="">متراژ بنا: {{$house->building_area}} متر</strong>
                        </div>
                        <div class="space col-sm-3 col-sm-offset-3 col-xs-offset-3 col-xs-9">
                            <strong class=""> نوع محل: @if($house->area_type == 'in_complex')داخل شهرک @else دربست @endif</strong>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3 fl-right space-1">
                            قیمت خانه
                        </div>
                        <div class="space col-lg-4-- col-xs-9 col-xs-offset-3 space-1">
                            <strong class="">شنبه شب تا سه شنبه شب (وسط هفته): <span class="priceReadable"  price="{{$house->min_price}}"></span></strong>
                        </div>
                        <div class="space col-lg-4-- col-sm-6-- col-xs-9 col-xs-offset-3 space-1">
                            <strong class="">چهار شنبه شب تا جمعه شب (آخر هفته):   <span class="priceReadable"  price="{{$house->median_price}}"></span></strong>
                        </div>
                        <div class="space col-lg-4-- col-sm-6-- col-lg-offset-3-- col-xs-offset-3 col-xs-9 space-1">
                            <strong class="">تعطیلات خاص و ایام شلوغ سال (ایام پیک): <span class="priceReadable" price="{{$house->max_price}}"></span> </strong>
                        </div>
                        <div class="space col-lg-4-- col-sm-6-- col-xs-9 col-xs-offset-3 space-1">
                            <strong class=""> نفر اضافه: @if($house->extra_person != 0)<span class="priceReadable" price="{{$house->extra_person}}"></span>@else 0 @endif </strong>
                        </div>
                        <div class="space col-lg-4-- col-sm-6-- col-xs-offset-3 col-lg-offset-3-- col-xs-9 space-1">
                            <strong class=""> تخفیف:  @if($house->discount_days != 0) بالای {{$house->discount_days}} روز {{$house->discount_rate}}  درصد</strong> @else ندارد @endif
                        </div>
                    </div><hr>
                    <div class="row">
                        <div class="col-sm-3 fl-right">
                            توضیحات
                        </div>
                        <div class="col-sm-9 ">
                            <div class="row">
                                <div class="col-md-10 w-wrap">
                                    {{ $house->description }}
                                </div>
                            </div>
                        </div>
                    </div><hr>

                </div>
            </div>

            <!--  <div class="row">
                <div class="col-sm-3">
                    The space
                </div>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="space">
                                <span>Accommodates: </span>
                                <strong>7</strong>
                            </div>
                            <div class="space">
                                <span>Accommodates: </span>
                                <strong>8</strong>
                            </div>
                            <div class="space">
                                <span>Accommodates: </span>
                                <strong>9</strong>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="space">
                                <span>Accommodates: </span>
                                <strong>10</strong>
                            </div>
                            <div class="space">
                                <span>Accommodates: </span>
                                <strong>11</strong>
                            </div>
                            <div class="space">
                                <span>Accommodates: </span>
                                <strong>12</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>

<div id="photo-gallery activeSlider" class="space-top-4 photo-grid col-lg-12">
    <div class="row">
        <?php $images = $house->photos()->get();
        $imagesCount = count($images);
        $i=0;
        ?>

        <ul class="lightgallery">
        @foreach($images as $image)
            <?php $imgPath = $image['thumbnail_path'];
                    $imgPathFull = $image['path']
            ?>
            @if ($i == 0 )
                <div data-src="/{{$imgPathFull}}" class="mg-1-t mg-r-051 col-sm-4 col-xs-8 col-sm-offset-1 col-xs-offset-2 col-md-offset-1 featured-height first ">
                    <img class="host-imgs" name="/{{$imgPath}}">
                </div>
            @elseif ($i == 1)
                <div data-src="/{{$imgPathFull}}"  class=" mg-1 col-sm-4 col-xs-6 col-xs-offset-3 hidden-xs mg-t-1 featured-height  col-sm-offset-0">
                    <img class="host-imgs" name="/{{$imgPath}}">
                </div>                                @elseif ($i == 2)
                <div data-src="/{{$imgPathFull}}"  class="col-md-2 mg-1-t col-sm-offset-2 col-md-offset-1 hidden-xs hidden-md1 hidden-sm  bottom-height first ">
                    <img class="host-imgs" name="/{{$imgPath}}">
                </div>
            @elseif ($i == 3)
                <div data-src="/{{$imgPathFull}}"  class="col-md-2 mg-1 hidden-xs hidden-md1 hidden-sm  bottom-height ">
                    <img class="host-imgs" name="/{{$imgPath}}">
                </div>
                @elseif ($i == 4)
                    <div data-src="/{{$imgPathFull}}"  class="col-md-2 mg-1 hidden-xs hidden-md1 hidden-sm bottom-height  last">
                        <img class="host-imgs" name="/{{$imgPath}}">
                    </div>
                @elseif ($i == 5)
                    <div data-src="/{{$imgPathFull}}"  class="col-md-2 mg-1 hidden-xs hidden-md1 hidden-sm bottom-height  last">
                        <img class="host-imgs" name="/{{$imgPath}}">
                        @if($imagesCount > 5)
                            <div class="allImages col-xs-11 text-center">مشاهده تمامی {{ $imagesCount }} عکس </div>
                        @endif
                    </div>
                @else
                <div hidden data-src="/{{$imgPathFull}}">
                    <img class="host-imgs" name="/{{$imgPath}}">
                </div>
                @endif

            <?php $i = $i+1; ?>
        @endforeach
            </ul>


    </div>
</div>
</div>
{{--   <div class="reviews col-md-10 col-md-offset-1 " id="reviews">
      <div class="panel">
          <div class="col-md-8">
              <h3 hidden>No review yet</h3>
              <div class="review-header space-top-4">
                  <div class="col-sm-12">
                      <h4>
                      <span>4 reviews</span>
                      <div style="display: inline-block;">
                          <div class="stars">
                              <div class="background">
                                  <i class="fa fa-star"></i>
                                  <i class="fa fa-star"></i>
                                  <i class="fa fa-star"></i>
                                  <i class="fa fa-star"></i>
                                  <i class="fa fa-star"></i>
                              </div>
                              <div class="foreground">
                                  <i class="fa fa-star"></i>
                                  <i class="fa fa-star"></i>
                                  <i class="fa fa-star"></i>
                                  <i class="fa fa-star"></i>
                              </div>
                          </div>
                      </div>
                      </h4>
                      <hr>
                      <div class="row ">
                          <div class="col-sm-3">
                              The space
                          </div>
                          <div class="col-sm-9">
                              <div class="row stars-summary space-4">
                                  <div class="col-md-6">
                                      <div class="space item1">
                                          <span>Accommodates: </span>
                                          <div class="stars">
                                              <div class="background">
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                              </div>
                                              <div class="foreground">
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="space item2">
                                          <span>Accommodates: </span>
                                          <div class="stars">
                                              <div class="background">
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                              </div>
                                              <div class="foreground">
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="space item3">
                                          <span>Accommodates: </span>
                                          <div class="stars">
                                              <div class="background">
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                              </div>
                                              <div class="foreground">
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-md-6">

                                      <div class="space item4">
                                          <span>Accommodates: </span>
                                          <div class="stars">
                                              <div class="background">
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                              </div>
                                              <div class="foreground">
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="space item5">
                                          <span>Accommodates: </span>
                                          <div class="stars">
                                              <div class="background">
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                              </div>
                                              <div class="foreground">
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="space item6">
                                          <span>Accommodates: </span>
                                          <div class="stars">
                                              <div class="background">
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                              </div>
                                              <div class="foreground">
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                                  <i class="fa fa-star"></i>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="review-content">
                  <div class="panel-body">
                      <div class="row">
                          <div class="col-sm-3 text-center space-2">
                              <div class="media-photo">
                                  <a href="#2131" class="media-photo media-round">
                                      <!-- <img height="67" width="67" src="{{asset('img/wall.jpg')}}"> -->
                                  </a>
                              </div>
                              <div class="name">
                                  <a href="#1112" class="text-muted">
                                      Name
                                  </a>
                              </div>
                          </div>
                          <div class="col-sm-9">
                              <div class="space-2">
                                  <p>  </p>
                                  <hr>
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-sm-3 text-center space-2">
                              <div class="media-photo">
                                  <a href="#2131" class="media-photo media-round">
                                      <!-- <img height="67" width="67" src="{{asset('img/wall.jpg')}}"> -->
                                  </a>
                              </div>
                              <div class="name">
                                  <a href="#1112" class="text-muted">
                                      Name
                                  </a>
                              </div>
                          </div>
                          <div class="col-sm-9">
                              <div class="space-2">
                                  <p>  </p>
                                  <hr>
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-sm-3 text-center space-2">
                              <div class="media-photo">
                                  <a href="#2131" class="media-photo media-round">
                                      <!-- <img height="67" width="67" src="{{asset('img/wall.jpg')}}"> -->
                                  </a>
                              </div>
                              <div class="name">
                                  <a href="#1112" class="text-muted">
                                      Name
                                  </a>
                              </div>
                          </div>
                          <div class="col-sm-9">
                              <div class="space-2">
                                  <p class="space-4">  </p>
                                  <span class="text-muted space-top-2">july 2016</span>
                                  <hr>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div> --}}
{{--  <div class="host-profile col-md-10 col-md-offset-1 " id="host">
     <div class="row">
         <div class="col-md-8">
             <h4>Your Host</h4>
             <hr class="space-4 space-top-2">
             <div class="col-sm-3 text-center space-2">
                 <div class="media-photo">
                     <a href="#2131" class="media-photo media-round">
                         <img class="host-img" height="67" width="67" src="@if($house->user['picture'] != '') {{$house->user['picture']}} @else {{asset('img/wall.jpg')}} @endif">
                     </a>
                 </div>
             </div>
             <div class="col-sm-9">
                 <h3>Name</h3>
                 <div class="col-sm-12 text-muted pad-off space-2">
                     <span>Location here</span>
                     <span> . </span>
                     <span>Member since felan</span>
                 </div>
                 <div class="space-2">
                     <div class="col-sm-12 pad-off">
                         <div>
                             <span>Response rate: </span>
                             <span>100%</span>
                         </div>
                         <div>
                             <span>Response time: </span>
                             <span>within a day</span>
                         </div>
                     </div>
                 </div>
                 <div class="space-top-4">
                     <div class="badge-container space-4 space-top-4">
                         <a href="#reviews">
                             <div class="text-center">
                                 <div class="badge-pill">
                                     <span class="count">8</span>
                                 </div>
                                 <span class="badge-pill-label">
                                     reviews
                                 </span>
                             </div>
                         </a>
                     </div>
                     <div class="badge-container space-4 space-top-4">
                         <a href="#reviews">
                             <div class="text-center">
                                 <div class="badge-pill">
                                     <span class="count">1</span>
                                 </div>
                                 <span class="badge-pill-label">
                                     verified
                                 </span>
                             </div>
                         </a>
                     </div>
                 </div>
                 <button class="space-4 btn btn-default">
                 contact host
                 </button>
             </div>
         </div>
     </div>
 </div> --}}
<form method="get" style="display:none" id="payform" action="{{url('/houses/reserve/'.$house->id)}}">
    <input type="hidden" name="checkin">
    <input type="hidden" name="checkout">
    <input type="hidden" name="accomodates">
    <input type="submit" name="">
</form>
<div class="neighborhood col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 mg-t-7" id="neighborhood"></div>
</div>
</div>
@extends('footer')
<script type="text/javascript">
    $(document).ready(function(){
        $('.lightgallery').lightGallery();
        $('.activeLightgallery').on('click', function () {
            $('.lightgallery div').click();
        })

        $('body').css('background-color', '#f9f9f9');
        appendAllPrices();
        priceToPersianNumber();

        $('img.host-imgs').each(function(){
            if($(this).attr('name')) {
                $(this).attr('src', $(this).attr('name'));
            }
        });
        isMobile = false;
        $('input[name="start_xs"]').datepicker();
        $('input[name="end_xs"]').datepicker();

        $('.host-imgs-top1').parent().css('text-align', 'center');
        $('.book-price').on('click', function() {
            $(this).append('<p class="info-pr">این قیمت برای روزهای عادی سال در نظر گرفته شده است. قیمت نهایی رزرو پس از وارد کردن تاریخ رفت و برگشت و تعداد نفرات محاسبه خواهد شد.</p>')
        });
        $('.button_book').on('click', function() {
            $('.button_book_info').show();
            isMobile = true;
            $('#header, .room-content, footer, .activeSlider').hide();
        });
        $('body').on('mouseup', function(e) {
            var container = $(".info-pr");
            if (!container.is(e.target) // if the target of the click isn't the container...
                    && container.has(e.target).length === 0) // ... nor a descendant of the container
            {
                container.remove();
            }
        });
        $('.submitBtn').click(function(e) {
            var count;
            if(isMobile) {
                var sSelector = 'input[name="start_xs"]';
                var eSelector = 'input[name="end_xs"]';
                count = 'input[name="guests_xs"]';
            }
            else {
                var sSelector = 'input[name="checkin_lg"]';
                var eSelector = 'input[name="checkout_lg"]';
                count = 'input[name="guests"]';
            }
            if($(sSelector).val() == '' || $(eSelector).val() == '') {
                setTimeout(
                        function()
                        {
                            $('.modal').hide();
                            $('.modal-backdrop').remove();
                            alert('ابتدا تاریخ رفت و برگشت را مشخص کنید');
                        }, 270);
                return false;
            }
            var cinDate = moment($(sSelector).val(), 'jDD/jMM/jYYYY');
            cinDate = cinDate.format('YYYY-MM-DD');
            var coutDate = moment($(eSelector).val(), 'jDD/jMM/jYYYY');
            coutDate = coutDate.format('YYYY-MM-DD');
            $('input[name="checkin"]').val(moment(cinDate).unix());
            $('input[name="checkout"]').val(moment(coutDate).unix());
            $('input[name="accomodates"]').val($(count).val());
            var now = new Date();
            var startOfDay = new Date(now.getFullYear(), now.getMonth(), now.getDate());
            now = startOfDay / 1000;
            if(moment(cinDate).unix() < now) {
                alert('تاریخ رفت نمی تواند قبل از تاریخ امروز باشد.');
                return false;
            }
            else if(moment(coutDate).unix() < now) {
                alert('تاریخ برگشت نمی تواند قبل از تاریخ امروز باشد.');
                return false;
            }
            else if(moment(coutDate).unix() < moment(cinDate).unix() + 86400) {
                alert('تاریخ برگشت می‌بایست حداقل یک روز بعد از تاریخ رفت باشد.');
                return false;
            }
            $('#payform').submit();
        });

        $('#submit').click(function(){
            $('#reqform').submit();
        });
        setTimeout(
                function()
                {
                    $('#supersized, #slides').hide();
                }, 200);
        setTimeout(
                function()
                {
                    $('#slides').append('<div class="close-slider"><i class="fa fa-close"></i></div>');
                }, 700);
    });
    $('.activeSlider').click(function(event) {
        $('#header, .room-content, footer').hide();
        $('#slides').show();
        $('img.host-imgs-top1').each(function(){
            if($(this).attr('name')) {
                $(this).attr('src', $(this).attr('name'));
            }
        });
    });
    $(document.body).on("click", ".close-slider", function(a) {
        $('#header, .room-content, footer, .activeSlider').show();
        isMobile =false;
        $('#slides').hide();
        $('.button_book_info').hide();
    });
    $("#photos1").addClass('brdr-bttm');
    $('.scroll').click(function(event) {
        var main = $('.subnav ul');

        event.preventDefault();
        var $this = $(this);
        var full_url = this.href,
                parts = full_url.split('#'),
                trgt = parts[1],
                target_offset = $('#'+trgt).offset(),
                target_top = target_offset.top;

        $('html, body').animate({scrollTop:target_top-40},0);

        setTimeout(
                function()
                {
                    main.children().find('a').removeClass('brdr-bttm');
                    $this.addClass('brdr-bttm');
                    $('#slides').append('<div class="close-slider">x</div>')
                }, 700);
    });

    $(window).scroll(function(event) {
        var main = $('.subnav ul');
        if($(window).scrollTop() < 366 ) {
            $('.subnav').hide();
//  $('.book-it').removeClass('book-it-fixed');
        }
        else {
            if($(window).width() > 767) {
                $('.subnav').show();
// $('.book-it').addClass('book-it-fixed');
            }
            else
                $('.book-it').hide();
        }
        if($(window).scrollTop() > 1087) {
            $('.book-it').hide(100);
        }
        else if($(window).scrollTop() >= 366) {
            $('.book-it').show(100);
        }
        if($("#photos").offset().top < $(window).scrollTop()) {
            main.children().find('a').removeClass('brdr-bttm');
            $("#photos1").addClass('brdr-bttm');
        }
        if($("#summary").offset().top < $(window).scrollTop()) {
            main.children().find('a').removeClass('brdr-bttm');
            $("#summary1").addClass('brdr-bttm');
        }
// if($("#reviews").offset().top < $(window).scrollTop()) {
// main.children().find('a').removeClass('brdr-bttm');
// $("#reviews1").addClass('brdr-bttm');
// }
// if($("#host").offset().top < $(window).scrollTop()) {
// main.children().find('a').removeClass('brdr-bttm');
// $("#host1").addClass('brdr-bttm');
// }
        if($("#neighborhood").offset().top < $(window).scrollTop()) {
            main.children().find('a').removeClass('brdr-bttm');
            $("#neighborhood1").addClass('brdr-bttm');
        }

    });


</script>
<script type="text/javascript">
    var map;
    map = new GMaps({
        el: '#neighborhood',
        lat: 35.76752801,
        lng: 51.37678955,
        zoomControl : true,
        zoomControlOpt: {
            style : 'SMALL',
            position: 'TOP_LEFT'
        },
        panControl : false,
        streetViewControl : false,
        mapTypeControl: false,
        overviewMapControl: false,
        scrollwheel: false,
        navigationControl: false,
        mapTypeControl: false,
        scaleControl: false,
        draggable: true,
    });
    var markers = [];
    poi_marker = {
        lat: '{{ $house->latitude }}',
        lng: '{{ $house->longitude }}',
        infoWindow: {
            content: '{{ $house->title }}'
        }
    }
    markers.push(poi_marker);
    map.addMarkers(markers);
    // GMaps.geolocate({
    //   success: function(position) {
    map.setCenter('{{ $house->latitude }}', '{{ $house->longitude }}');
    //  },
    // });
    map.setZoom(12);
</script>
@if (session('status') == 'OK')
    <?php echo "<script type='text/javascript'>
                    $(document).ready(function(){
                        alert('درخواست رزرو شما با موفقیت در سایت شب ثبت گردید. پس از اعلام وضعیت توسط میزبان، نتیجه درخواست از طریق پیامک به اطلاع شما خواهد رسید')
                    })
                </script>"; ?>
@endif