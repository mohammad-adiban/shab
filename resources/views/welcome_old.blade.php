@include('header')
<!-- search bar section -->
<section class="s1">
    <div class="slider">
        <div class="sh-slideshow">
            <ul class="list-unstyled sh-slider">
                <?php
                $files = glob('img/slider/*.jpg');
                $i = 0;
                ?>
                @foreach ($files as $image)
                <?php $i++; ?>
                @if($i == 1)
                <li class="sh-slide active">
                    <img class="slider-img first_slide" src="{{$image}}" alt="سایت شب - اجراه روزانه ویلا">
                </li>
                @else
                <li class="sh-slide">
                    <img class="slider-img" name="{{$image}}" alt="سایت شب - اجاره روزانه ویلا">
                </li>
                @endif
                @endforeach
            </ul>
        </div>
    </div>
    <div class="container hero">
        <div class="s1-container col-lg-12">
            <div class="s1-container-2">
                <h2><lng key="index.welcome"></lng></h2>
                <h4 class="hidden-xs"><lng key="index.welcomeDesc"></lng></h4>
                <a id="how-it-works" href="#intro"><lng key="index.shabHelp"></lng></a>
            </div>
        </div>
    </div>
    <div id="search-bar" class="search-bar">
        <div class="search-bar-1">
            <form id="search-form" action="search" method="GET">
                <div class=" col-sm-8 col-xs-8 col-xs-offset-2 pad-r-0 pad-l-0">
                    <div class="col-lg-4 col-md-4 col-sm-10 col-xs-8 pad-r-0 pad-l-0">
                        <div class="col-xs-12 pad-r-0 pad-l-0">
                            <input name="des" autocomplete="on" dir="auto" placeholder="index.destination" id="destination" type="text" class=" text-left form-control  inp-padding">
                        </div>
                    </div>
                    <div class="col-xs-2 pad-r-0 pad-l-0 hidden-xs hidden-sm ">
                        <div class="col-xs-12 pad-r-0 pad-l-0">
                            <input name="checkin" dir="auto" id="checkin" placeholder="index.startDate" type="text" class=" text-left form-control date_picker border-r-0">
                            <div class="col-xs-1 col-padding arrow"><i class="fa fa-long-arrow-right"></i></div>
                        </div>
                    </div>
                    <div class="col-xs-2 pad-r-0 pad-l-0 hidden-xs hidden-sm">
                        <div class="col-xs-12 pad-r-0 pad-l-0">
                            <input name="checkout" dir="auto" id="checkout" placeholder="index.retDate" type="text" class="form-control date_picker text-left border-l-0">
                        </div>
                    </div>
                    <div class="col-xs-2 pad-r-0 pad-l-0 hidden-xs hidden-sm">
                        <div class="col-xs-12 pad-r-0 pad-l-0">
                            <select name="guests" dir="rtl" id="guests" class="form-control">
                                <option value="">چند نفرید؟</option>
                                @for ($i = 1; $i <= 15; $i++)
                                <option value="{{$i}}">{{$i}} نفر</option>
                                @endfor
                                <option value="16">+16 نفر</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-2 pad-r-0 pad-l-0">
                        <button  id="searchbar-submit" class="col-xs-12 pad-r-0 pad-l-0 btn btn-success" type="submit">
                        <span class="hidden-sm hidden-xs a2"><lng key="index.search"></lng></span><i class="visible-xs visible-sm fa fa-search"></i>
                        </button>
                    </div>
                </div>
                {{-- <div class="col-xs-5 col-padding">
                    
                </div>
 --}}
                {{--
                <div class="col-md-offset-2 col-xs-offset-1 searchbar">
                    <button id="searchbar-submit" class="btn btn-success a1" type="submit"><span class="hidden-sm hidden-xs"><lng key="index.search"></lng></span><i class="visible-xs visible-sm fa fa-search"></i></button>
                    <div class="col-xs-1 col-padding  hidden-xs a2">

                    </div>
                    --}}
                </div>
                
                
            </form>
        </div>
    </div>
    <div class="col-lg-6 col-sm-4 col-xs-8 col-xs-offset-2 map-select">
        <div id="close-dest" class="close">
            <i class="fa fa-remove"></i>
        </div>
        <div class="inl-blk flt-rtl">
            <div class="col-xs-12 flt-rtl cities top-3">
                <p style="position:absolute;">می توانید یکی از این استان ها را انتخاب کنید:</p>
                <?php $i=0; $cities= \App\House::distinct()->select('city')->where('temp', 0)->where('disabled', 0)->orderBy('city', 'asc')->get(); $count = 10; ?>
                <!-- get cities from db -->
                @foreach($cities as $city)
                    @if($i==0)
                        <div class="city col-sm-5 first">
                            <a href="{{url('/search')}}?des={{$city['city']}}">{{$city['city']}} ({{ \App\House::where('city', $city['city'])->where('temp', 0)->where('disabled', 0)->get()->count() }} خانه)</a>
                        </div>
                        <?php $i++; ?>
                    @else
                        <div class="city col-sm-5">
                            <a href="{{url('/search')}}?des={{$city['city']}}">{{$city['city']}} ({{ \App\House::where('city', $city['city'])->where('temp', 0)->where('disabled', 0)->get()->count() }} خانه)</a>
                        </div>
                    @endif
                @endforeach
                {{--<div class="city first">--}}
                    {{--<a href="{{url('/search')}}?des=اصفهان">اصفهان (۶ خانه)</a>--}}
                {{--</div>--}}
                {{--<div class="city">--}}
                    {{--<a href="{{url('/search')}}?des=کاشان">کاشان (۴ خانه)</a>--}}
                {{--</div>--}}
                {{--<div class="city">--}}
                    {{--<a href="{{url('/search')}}?des=مازندران">مازندران (۱۳۳ خانه)</a>--}}
                {{--</div>--}}
                {{--<div class="city">--}}
                    {{--<a href="{{url('/search')}}?des=البرز">البرز (۲ خانه)</a>--}}
                {{--</div>--}}
                {{--<div class="city">--}}
                    {{--<a href="{{url('/search')}}?des=تهران">تهران (۶ خانه)</a>--}}
                {{--</div>--}}
                {{--<div class="city">--}}
                    {{--<a href="{{url('/search')}}?des=اردبيل">اردبيل (۳ خانه)</a>--}}
                {{--</div>--}}
                {{--<div class="city">--}}
                    {{--<a href="{{url('/search')}}?des=گلستان">گلستان (۵ خانه)</a>--}}
                {{--</div>--}}
                {{--<div class="city">--}}
                    {{--<a href="{{url('/search')}}?des=خراسان+رضوی">خراسان رضوي (۳۳ خانه)</a>--}}
                {{--</div>--}}
                {{--<div class="city">--}}
                    {{--<a href="{{url('/search')}}?des=سمنان">سمنان(۳ خانه)</a>--}}
                {{--</div>--}}
            </div>
        </div>

    </div>
</section>
<!-- end of search bar section -->
<!-- section between header and footer -->


<section class="discovery-container pd-t-3">
    <div class="container">
        <div class="col-xs-12 panel-3 text-center">
            <div class="col-xs-12">
                <h1>پیشنهاد ویژه</h1>
            </div>
            <div class="col-xs-12">
                <h4>خانه های دارای تخفیف ویژه و استثنایی</h4>
            </div>
        </div>
        <div class="col-sm-12 col-sm-offset-0 col-xs2-12 col-xs-8 col-xs-offset-2 col-xs2-offset-0 items">
            <div class="col-lg-3 col-md-4 col-sm-6 item">
                <a href="houses/show/478">
                    <img src="{{asset('img/special_ads/478.jpg')}}" alt="اجاره روزانه ویلا-مازندران-چالوس-نزدیک دریا-دوبلکس">
                    <div style="display: none"  class="onHover">
                        <h3 class="text-center">از شبی <br> 200 هزار تومان<br><br> مازندران - چالوس<br>نزدیک دریا، دوبلکس</h3>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 item">
                <a href="houses/show/220">
                    <img src="{{asset('img/special_ads/220.jpg')}}" alt="اجاره روزانه ویلا-مازندران-چالوس-دوبلکس-ساحلی-کاملا مستقل">
                    <div style="display: none"  class="onHover">
                        <h3 class="text-center">از شبی <br> 820 هزار تومان<br><br> مازندران - چالوس<br>دوبلکس، ساحلی، کاملا مستقل</h3>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 item">
                <a href="houses/show/266">
                    <img src="{{asset('img/special_ads/266.jpg')}}" alt="اجاره روزانه ویلا-گیلان-شفت-دوبلکس-استخردار">
                    <div  style="display: none" class="onHover">
                        <h3 class="text-center">از شبی <br> 600 هزار تومان<br><br> گیلان - شفت<br>دوبلکس، استخردار</h3>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 item">
                <a href="houses/show/286">
                    <img src="{{asset('img/special_ads/286.jpg')}}" alt="اجاره روزانه ویلا-مازندران-تنکابن-دوبلکس-تجهیزات کامل">
                    <div style="display: none"  class="onHover">
                        <h3 class="text-center">از شبی <br> 250 هزار تومان<br><br> مازندران - تنکابن<br>دوبلکس، نوساز، تجهیزات کامل</h3>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 item">
                <a href="houses/show/341">
                    <img src="{{asset('img/special_ads/341.jpg')}}" alt="اجاره روزانه ویلا-مازندران-فومن-دوبلکس-استخر سرپوشیده و سرباز-نوساز-تجهیزات کامل">
                    <div style="display: none"  class="onHover">
                        <h3 class="text-center">از شبی <br> 1 میلیون و 395 هزار تومان<br><br> مازندران - فومن<br>دوبلکس، استخر سر پوشیده و سرباز، نوساز، تجهیزات کامل</h3>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 item">
                <a href="houses/show/350">
                    <img src="{{asset('img/special_ads/350.jpg')}}" alt="اجاره روزانه ویلا-مازندران-نوشهر-ساحلی-دنج و آرام">
                    <div style="display: none"  class="onHover">
                        <h3 class="text-center">از شبی <br> 200 هزار تومان<br><br> مازندران - نوشهر<br>ویلای ساحلی، دنج و آرام</h3>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 item">
                <a href="houses/show/363">
                    <img src="{{asset('img/special_ads/363.jpg')}}" alt="اجاره روزانه ویلا-مازندران-متل قو-دوبلکس-استخردار-داخل شهرک">
                    <div style="display: none"  class="onHover">
                        <h3 class="text-center">از شبی <br> 700 هزار تومان<br><br> مازندران - متل قو<br>دوبلکس، استخردار، داخل شهرک</h3>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 item">
                <a href="houses/show/39">
                    <img src="{{asset('img/special_ads/3.jpg')}}" alt="اجاره روزانه ویلا-مازندران-چالوس-جنگلی">
                    <div style="display: none"  class="onHover">
                        <h3 class="text-center">از شبی <br> 395 هزار تومان<br><br> مازندران - چالوس<br>جنگلی، استخر دار، شیک و دنج</h3>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 item">
                <a href="houses/show/157">
                    <img src="{{asset('img/special_ads/1.jpg')}}" alt="اجاره روزانه ویلا-مازندران-کلاردشت-3 خوابه- محوطه و آلاچیق زیبا">
                    <div style="display: none" class="onHover">
                        <h3 class="text-center">از شبی <br> 190 هزار تومان<br><br> مازندران - کلاردشت<br>3 خوابه، محوطه و آلاچیق زیبا</h3>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 item">
                <a href="houses/show/378">
                    <img src="{{asset('img/special_ads/378.jpg')}}" alt="اجاره روزانه ویلا-خراسان رضوی-مشهد-دو خوابه-دربست و بسیار شیک">
                    <div style="display: none" class="onHover">
                        <h3 class="text-center">از شبی <br> 250 هزار تومان<br><br> خراسان رضوی - مشهد مقدس<br>2 خوابه،‌ دربست و بسیار شیک</h3>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 item">
                <a href="houses/show/290">
                    <img src="{{asset('img/special_ads/290.jpg')}}" alt="اجاره روزانه ویلا-هرمزگان-جزیره کیش-ویلایی-لوکس-دامون">
                    <div style="display: none" class="onHover">
                        <h3 class="text-center">از شبی <br> 550 هزار تومان<br><br> هرمزگان - جزیره کیش<br>2 خوابه،‌ ویلایی، لوکس،‌ دامون</h3>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 item">
                <a href="houses/show/353">
                    <img src="{{asset('img/special_ads/353.jpg')}}" alt="اجاره روزانه ویلا-تهران-تهران-یک خوابه-شمس آباد">
                    <div style="display: none" class="onHover">
                        <h3 class="text-center">از شبی <br> 260 هزار تومان<br><br> تهران - تهران<br>1 خوابه،‌ شمس آباد</h3>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>


<section class="s2" id="intro">
    <div class="container">
        <div class="col-lg-12 col-lg-offset-1s">
            <div class="space-top-2">
                <div class="col-md-4 step-1 flt-r">
                    <div class="panel-body">
                        <div class="bg-img"></div>
                        <h3 class="text-center">بیابید</h3>
                        <p>میتوانید به راحتی با جستجو در شب، انبوهی از اقامتگاه‌ها را بررسی کرده و با مقایسه آن ها، اقامتگاه مورد نظر خود را انتخاب کنید.</p>
                    </div>
                </div>
                <div class="col-md-4 step-2 flt-r">
                    <div class="panel-body">
                        <div class="bg-img"></div>
                        <h3 class="text-center">رزرو کنید</h3>
                        <p>محلی را که انتخاب کرده‌اید به راحتی در شب رزرو کرده و آماده‌ی سفر شوید.</p>
                    </div>
                </div>
                <div class="col-md-4 step-3 flt-r">
                    <div class="panel-body">
                        <div class="bg-img"></div>
                        <h3 class="text-center">لذت ببرید</h3>
                        <p>به مکان مورد نظرتان سفر کنید و از اقامتتان لذت یبرید و تجربیاتتان را با دیگران به اشتراک گذارید!</p>
                    </div>
                </div>
            </div>
            <div class="col-md-10 col-md-offset-1 learn-more">اگر دوست دارید راجع به روند کار بیشتر بدانید، می توانید <a href="/help/guest">اینجا</a> مطالعه کنید.
        </div>
    </div>
</div>
</section>
</body>
<script type="text/javascript">
$(document).ready(function() {
check_image();
    $(".s1").height($(".sh-slide img").height() - 40 + 'px');
  //  $(".discovery-container").css("margin-top", $(".slider").height() - $(".s1").height());
    $('.panel-body').click(function(){
        window.location.href = "search?des=";
    });

// $('#loading').fadeOut(1500);
$('#destination').on('click', function(e) {
$('.map-select').show();
//$('.map-select').css('width', $('.a1').width()+$('.a2').width()+$('.a3').width()+$('.a4').width()+'px');
});
$('#destination').on('keydown', function(e) {
if($(".map-select").is(":visible")) {
$('.map-select').hide();
}
});
    $('#close-dest, body').on('mouseup', function(e) {
        $('.map-select').hide();
        var container = $(".map-select");
        if (!container.is(e.target) // if the target of the click isn't the container...
                && container.has(e.target).length === 0) // ... nor a descendant of the container
        {
            container.hide();
        }
    });





    function check_image() {
if(document.querySelector('img.slider-img.first_slide').complete) {
$('img.slider-img').each(function(){
if($(this).attr('name')) {
$(this).attr('src', $(this).attr('name'));
}
});
slider_loop();
}
else {
setTimeout(
function()
{
check_image();
}, 600);
}
}
function slider_loop() {
window.setInterval(function(){
var $active = $('ul.sh-slider .active');
var $next = ($active.next().length > 0) ? $active.next() : $('ul.sh-slider li:first');
$next.css('z-index',2);
$active.fadeOut(1500,function(){
$active.css('z-index',1).show().removeClass('active');
$next.css('z-index',3).addClass('active');
});
}, 30000);
}

    $(".item a").on("mouseenter", function () {
        $(this).find('.onHover').fadeIn(100);
    });
    $(".item a").on("mouseleave", function () {
        $(this).find('.onHover').fadeOut(100);
    });

    $('#searchbar-submit').click(function(e) {
            var sSelector = 'input[name="checkin"]';
            var eSelector = 'input[name="checkout"]';

        var cinDate = moment($(sSelector).val(), 'jDD/jMM/jYYYY');
        cinDate = cinDate.format('YYYY-MM-DD');
        var coutDate = moment($(eSelector).val(), 'jDD/jMM/jYYYY');
        coutDate = coutDate.format('YYYY-MM-DD');
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
        else if(moment(coutDate).unix() < moment(cinDate).unix()) {
            alert('تاریخ برگشت نمی تواند قبل از تاریخ رفت باشد.');
            return false;
        }
        return true;
    });
});
</script>

<script type="text/javascript" src="{{ asset('js/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/moment-jalaali.js') }}"></script>
@extends('footer')
