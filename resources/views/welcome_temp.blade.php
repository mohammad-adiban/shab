@include('header')
<!-- search bar section -->
<link href="css/index.rtl.css" rel="stylesheet"/>
<script>
var styleSheets = document.styleSheets;
var href = 'https://www.shab.ir/css/index-rtl.css?v=1.2.6';
for (var i = 0; i < styleSheets.length; i++) {
    if (styleSheets[i].href == href) {
        styleSheets[i].disabled = true;
        break;
    }
}
</script>
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
                    <img class="slider-img first_slide" src="{{$image}}" alt="سایت شب - خدمات گردشگری ایرانی">
                </li>
                @else
                <li class="sh-slide">
                    <img class="slider-img" name="{{$image}}" alt="سایت شب - خدمات گردشگری ایرانی">
                </li>
                @endif
                @endforeach
            </ul>
        </div>
    </div>
    <div class="container hero">
        <div class="s1-container col-lg-12">
            <div class="s1-container-2">
                <h2><p>خدمات گردشگری ایرانی</p></h2>
                <h4 class="hidden-xs"><p>هر آنچه برای سفر لازم است بدانید</p></h4>
                <h4 class="hidden-xs" style="position: absolute;left: 0;top: 20px;font-size: 14px;"><p>رزرو اماکن اقامتی این سامانه از طریق شرکت خدمات مسافرتی ژورک سعادت می‌باشد.</p></h4>
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
        </div>
        <div class="col-sm-12 col-sm-offset-0 col-xs2-12 col-xs-8 col-xs-offset-2 col-xs2-offset-0 items">
            <div class="col-lg-3 col-md-4 col-sm-6 item">
                <a href="houses/show/109">
                    <img src="{{asset('img/special_ads/109.jpg')}}" alt="">
                    <div style="display: none"  class="onHover">
                        <h3 class="text-center">از شبی <br> 50 هزار تومان<br><br> خراسان رضوی - مشهد<br>هتل آپارتمان مالک اشتر، اینترنت وایرلس</h3>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 item">
                <a href="houses/show/140">
                    <img src="{{asset('img/special_ads/140.jpg')}}" alt="">
                    <div style="display: none"  class="onHover">
                        <h3 class="text-center">از شبی <br> 35 هزار تومان<br><br> خراسان رضوی - مشهد<br>هتل آپارتمان ایرانمنش، 10 دقیقه تا حرم</h3>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 item">
                <a href="houses/show/111">
                    <img src="{{asset('img/special_ads/111.jpg')}}" alt="">
                    <div  style="display: none" class="onHover">
                        <h3 class="text-center">از شبی <br> 100 هزار تومان<br><br> خراسان رضوی - مشهد<br>هتل آپارتمان، معرفی نامه موج‌های آبی</h3>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 item">
                <a href="houses/show/110">
                    <img src="{{asset('img/special_ads/110.jpg')}}" alt="">
                    <div style="display: none"  class="onHover">
                        <h3 class="text-center">از شبی <br> 90 هزار تومان<br><br> خراسان رضوی - مشهد<br>هتل آپارتمان کوثر، 10 دقیقه تا حرم</h3>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 item">
                <a href="http://hoteltoos.com/?page=reserve-offline">
                    <img src="{{asset('img/special_ads/toos.jpg')}}" alt="">
                    <div style="display: none"  class="onHover">
                        <h3 class="text-center">خراسان رضوی - مشهد<br>هتل توس</h3>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 item">
                <a href="houses/show/214">
                    <img src="{{asset('img/special_ads/hotel1.jpg')}}" alt="">
                    <div style="display: none"  class="onHover">
                        <h3 class="text-center">از شبی <br> 150 هزار تومان<br><br> خراسان رضوی - مشهد<br>هتل آپارتمان مارین، 10 دقیقه تا حرم</h3>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 item">
                <a href="houses/show/213">
                    <img src="{{asset('img/special_ads/hotel2.jpg')}}" alt="">
                    <div style="display: none"  class="onHover">
                        <h3 class="text-center">از شبی <br> 180 هزار تومان<br><br> خراسان رضوی - مشهد<br>هتل آپارتمان ناهید، نزدیک حرم</h3>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 item">
                <a href="houses/show/187">
                    <img src="{{asset('img/special_ads/hotel3.jpg')}}" alt="">
                    <div style="display: none"  class="onHover">
                        <h3 class="text-center">از شبی <br> 190 هزار تومان<br><br> خراسان رضوی - مشهد<br>هتل آپارتمان بیت الکریم، نزدیک حرم، شیک</h3>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
<section class="s2" id="intro" style="min-height: 500px">
    <div class="container">
        <div class="col-xs-12 panel-3 text-center">
            <div class="col-xs-12">
                <h1>مطالب وبلاگ شب</h1>
            </div>
        </div>
        <div class="col-lg-12 col-lg-offset-1s">
            <div class="space-top-2">
                <div class="col-md-4 step-1 flt-r">
                    <div class="panel-body">
                        <div style="background-size:100%;background-position:center;background-repeat:no-repeat;height:200px;margin:0 auto;max-width: 283px">
                            <div class="col-lg-3 col-md-4 col-sm-6" style="height: 200px;margin:15px -30px">
                                <a href="blog/2017/02/اصفهان،-موزه-ای-که-مردم-در-آن-زندگی-میکن/">
                                    <img style="border-radius: 5%" src="{{asset('img/special_ads/blog_3.jpg')}}" alt="">
                                </a>
                            </div>
                        </div>
                        <h3 class="text-center">اصفهان، موزه ای که مردم در آن زندگی میکنند</h3>
                    </div>
                </div>
                <div class="col-md-4 step-1 flt-r">
                    <div class="panel-body">
                        <div style="background-size:100%;background-position:center;background-repeat:no-repeat;height:200px;margin:0 auto;max-width: 283px">
                            <div class="col-lg-3 col-md-4 col-sm-6" style="height: 200px;margin:15px -30px">
                                <a href="blog/2017/03/جذابترین-مقاصد-ایران-کاشان/">
                                    <img style="border-radius: 5%" src="{{asset('img/special_ads/blog_1.jpg')}}" alt="">
                                </a>
                            </div>
                        </div>
                        <h3 class="text-center">جذابترین مقاصد ایران، کاشان</h3>
                    </div>
                </div>
                <div class="col-md-4 step-1 flt-r">
                    <div class="panel-body">
                        <div style="background-size:100%;background-position:center;background-repeat:no-repeat;height:200px;margin:0 auto;max-width: 283px">
                            <div class="col-lg-3 col-md-4 col-sm-6" style="height: 200px;margin:15px -30px">
                                <a href="blog/2017/04/نمک-آبرود،-جلوه-گاه-تحقق-روياهاي-گردشگ/">
                                    <img style="border-radius: 5%" src="{{asset('img/special_ads/blog_2.jpg')}}" alt="">
                                </a>
                            </div>
                        </div>
                        <h3 class="text-center">نمک آبرود، جلوه گاه تحقق رویاهای گردشگری</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-10 col-md-offset-1 learn-more">مطالب بیشتر را در <a href="/blog">اینجا</a> مطالعه کنید.
        </div>
    </div>

    {{--<div class="text-center">قرارداد با شرکت های خدماتی مسافرتی</div>--}}
    {{--<div class="row">    --}}
        {{--<div class="col-xs-6 mg-t-1" style="height: 300px;">--}}
            {{--<a href="img/contracts/photo_2017-07-05_19-59-37.jpg"><img style="width:50%;height:50%;margin-right:25%" src="img/contracts/photo_2017-07-05_19-59-37.jpg" /></a>--}}
        {{--</div>    --}}
        {{--<div class="col-xs-6 mg-t-1" style="height: 300px;">--}}
            {{--<a href="img/contracts/deal4.jpg"><img style="width:50%;height:50%;margin-right:25%" src="img/contracts/deal4.jpg" /></a>--}}
        {{--</div>--}}
    {{--</div>--}}

    {{--<div class="text-center">قرارداد با هتل آپارتمان</div>--}}
    {{--<div class="row">--}}
        {{--<div class="col-xs-4 mg-t-1" style="height: 300px;">--}}
            {{--<a href="img/contracts/mashad.jpg"><img style="width:50%;height:50%;margin-right:25%" src="img/contracts/mashad.jpg" /></a>--}}
        {{--</div>--}}

        {{--<div class="col-xs-4 mg-t-1" style="height: 300px;">--}}
            {{--<a href="img/contracts/mashad2.jpg"><img style="width:50%;height:50%;margin-right:25%" src="img/contracts/mashad2.jpg" /></a>--}}
        {{--</div>--}}

        {{--<div class="col-xs-4 mg-t-1" style="height: 300px;">--}}
            {{--<a href="img/contracts/hotel.jpg"><img style="width:50%;height:50%;margin-right:25%" src="img/contracts/hotel.jpg" /></a>--}}
        {{--</div>--}}
    {{--</div>--}}

    {{--<div class="text-center">قرارداد با هتل مشهد</div>--}}
        {{--<div class="col-xs-12 mg-t-1">--}}
        {{--<a href="img/contracts/deal5.jpg"><img style="width:50%;height:50%;margin-right:25%" src="img/contracts/deal5.jpg" /></a>--}}
    {{--</div>--}}
</div>
</section>

</body>
<script type="text/javascript">
$(document).ready(function() {
check_image();
    $(".s1").height($(".sh-slide img").height() - 40 + 'px');
  //  $(".discovery-container").css("margin-top", $(".slider").height() - $(".s1").height());

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
