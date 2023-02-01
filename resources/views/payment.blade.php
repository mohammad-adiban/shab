@include('header')
 <script type="text/javascript" src="{{ asset('js/moment.js') }}"></script>
 <script type="text/javascript" src="{{ asset('js/moment-jalaali.js') }}"></script>
<?php $prices = json_decode(getFactor($_GET['checkin'],$_GET['checkout'],$_GET['accomodates'],$house)); ?>
  <div class="mg-t-7 col-md-10 col-md-offset-1">
        <div class="modal-content col-md-8 col-md-offset-2">
            <div class="modal-header bold">
                تایید اطلاعات
            </div>
            <div style="text-align: center;font-weight: bold;color: red;padding-top: 8px;"> {{ session('status') }} </div>
	        @if (count($errors) > 0)
	            <div class="alert alert-danger">
	                <ul>
	                    @foreach ($errors->all() as $error)
	                        <li>{{ $error }}</li>
	                    @endforeach
	                </ul>
	            </div>
	        @endif
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <th class="col-xs-6 text-rtl">نام آگهی</th>
                        <td id="lname">{{ $house->title }}</td>
                    </tr>

                    <tr>
                        <th class="col-xs-6 text-rtl">نوع خانه</th>
                        <td id="htype">
                                @if($house->type =='room') اتاق شخصی
                                @elseif($house->type =='apartment') آپارتمان
                                @else ویلا 
                                @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="col-xs-6 text-rtl">تاریخ رفت</th>
                        <td id="cindate" value="{{date('m/d/Y', $_GET['checkin'])}}"></td>
                    </tr>

                    <tr>
                        <th class="col-xs-6 text-rtl">تاریخ برگشت</th>
                        <td id="coutdate" value="{{date('m/d/Y', $_GET['checkout'])}}"></td>
                    </tr>

                    <tr>
                        <th class="col-xs-6 text-rtl">تعداد نفرات</th>
                        <td id="count">{{ $_GET['accomodates'] }}</td>
                    </tr>

                    <tr>
                        <th class="col-xs-6 text-rtl">تعداد اتاق</th>
                        <td id="rooms">{{ $house->rooms }}</td>
                    </tr>

                    <tr>
                        <th class="col-xs-6 text-rtl">تعداد تخت</th>
                        <td id="beds">{{ $house->beds }}</td>
                    </tr>

                    <tr>
                        <th class="col-xs-6 text-rtl">شهر</th>
                        <td id="city">{{ $house->city }}</td>
                    </tr>
                    <tr>
                        <th class="col-xs-6 text-rtl"></th>
                        <td id="min_price"><div class="col-xs-4">تعداد</div><div class="col-xs-4 text-center ">هزینه</div><div class="col-xs-4 text-center ">مجموع</div></td>
                    </tr>

                    <tr>
                        <th class="col-xs-6 text-rtl price1_popup price_p">روزهای قیمت ایام خاص (<i class="fa fa-question"></i>)</th>
                        {{--<th class="col-xs-6 text-rtl">روزهای قیمت ایام خاص</th>--}}
                        <td id="max_price"><div class="col-xs-4">{{$prices->max_days}}</div><div class="col-xs-4 shortPrice priceReadable ignore pad-l-0 text-center " price="{{--$house->max_price--}}"></div><div class="col-xs-4 text-center priceReadable shortPrice pad-l-0" price="{{$prices->max_days_total}}"</div></td>
                    </tr>
                    <tr>
                        <th class="col-xs-6 text-rtl">روزهای قیمت آخر هفته</th>
                        <td id="med_price"><div class="col-xs-4">{{$prices->median_days}}</div><div class="col-xs-4 shortPrice priceReadable pad-l-0 text-center " price="{{$house->median_price}}"></div><div class="col-xs-4  text-center shortPrice priceReadable pad-l-0" price="{{$prices->median_days_total}}"></div></td>

                    </tr>
                    <tr>
                        <th class="col-xs-6 text-rtl">روزهای قیمت وسط هفته</th>
                        <td id="min_price"><div class="col-xs-4">{{$prices->min_days}}</div><div class="col-xs-4 shortPrice priceReadable pad-l-0 text-center " price="{{$house->min_price}}"></div><div class="col-xs-4 text-center  shortPrice priceReadable pad-l-0" price="{{$prices->min_days_total}}"></div></td>

                    </tr>
                    <tr>
                        <th class="col-xs-6 text-rtl">نفر اضافه</th>
                        <td id="min_price"><div class="col-xs-4">{{$prices->extra_person}}</div><div class="col-xs-4  shortPrice priceReadable pad-l-0 text-center " price="{{$house->extra_person}}"></div><div class="col-xs-4  text-center shortPrice priceReadable pad-l-0" price="{{$prices->extra_person_total}}"></div></td>
                    </tr>
            <tr>
                <th class="col-xs-6 text-rtl">تخفیف مدت رزرو</th>
                <td id="min_price"><div class="col-xs-4">{{-- $house->discount_rate --}}</div><div class="col-xs-4 pad-l-0"></div><div class="col-xs-4 pad-l-0 priceReadable shortPrice text-center " price="{{$prices->discount}}"></div></td> 
            </tr>
            {{-- <tr>
                <th class="col-xs-6">تخفیف ویژه</th>
                <td id="totla_price" class=" text-center"><div class="priceReadable  col-xs-6 col-xs-offset-7" price="{{$prices->special_discount}}"></div></td>
            </tr>
            --}}
            <tr>
                <th class="col-xs-6">جمع کل</th>
                <td id="totla_price" class=" text-center"><div class="priceReadable  col-xs-6 col-xs-offset-7" price="{{$prices->total_price}}"></div></td>
            </tr>

                    {{--<tr>--}}
                        {{--<th class="col-xs-6 text-rtl price1_popup price_p">قیمت کل (<i class="fa fa-question"></i>)</th>--}}
                        {{--<td id="price" class="priceReadable" price="{{ $prices->total_price }}"></td>--}}

                    {{--</tr>--}}
                    <!--
                    <tr>
                        <th class="col-xs-6 price2_popup price_p">پیش پرداخت (<i class="fa fa-question"></i>)</th>
                        <td id="prePayment"><div class=" text-center priceReadable col-xs-6 col-xs-offset-7" price="<?php 
                        if($prices->max_days + $prices->median_days + $prices->min_days == 1)
                            echo $prices->total_price;
                        else
                            echo floor((int) $prices->total_price / 2);
                        ?>"></div></td>

                    </tr>
                    -->
                </table>

            <form class="res-form" method="post" action="{{url('houses/reserve/'.$house->id)}}" >
                {{ csrf_field() }}
                <div class="modal-footer">
                <input type="hidden" name="checkin" value="{{ $_GET['checkin'] }}">
                <input type="hidden" name="checkout" value="{{ $_GET['checkout'] }}">
                <input type="hidden" name="accomodates" value="{{ $_GET['accomodates'] }}">
                    <a href="{{url('houses/show/'.$house->id)}}" type="button" class="btn btn-default left-1" data-dismiss="modal">بازگشت</a>
                    <input type="button" id="submit-call" class="btn btn-info" value="ثبت درخواست">
                    <input style="display: none" type="submit" id="submit" class="btn btn-success success" value="پرداخت"></a>
                </div>
            </form>
                 
            </div>
        </div>
    </div>
<p class="mg-t-3 col-xs-6 col-xs-offset-3">* قبول یا رد درخواست شما به صورت پیامکی به اطلاع شما خواهد رسید.</p>
<p class="mg-t-3 col-xs-6 col-xs-offset-3">* سؤالات خود را می‌توانید با شماره تلفن <a href="tel:+2122398202" target="_blank">٠٢١٢٢٣٩٨٢٠٢</a> یا با <a href="https://telegram.me/shab_ir" target="_blank">تلگرام شب</a> در میان گذارید.</p>
<p class="col-xs-6 col-xs-offset-3" style="margin-bottom: 30px;"></p>

    <script type="text/javascript">
            appendAllPrices();
            priceToPersianNumber();
        var cinDate = moment($('#cindate').attr('value'), 'MM/DD/YYYY');
            cinDate = cinDate.format('jYYYY/jMM/jDD'); 
        var coutDate = moment($('#coutdate').attr('value'), 'MM/DD/YYYY');
            coutDate = coutDate.format('jYYYY/jMM/jDD');

            $('#cindate').text(cinDate);
            $('#coutdate').text(coutDate);

    $('.price1_popup').on('click', function() {
        $(this).append('<p class="info-pr">این قیمت بر اساس ایام پیک سال و قیمت‌های خاصی که میزبان بر روی تقویم اقامتگاه خود تعیین کرده است محاسبه می‌شود.</p>')
    });
    /*$('.price2_popup').on('click', function() {
        $(this).append('<p class="info-pr">برای بیش از یک شب 50 درصد از قیمت کل و برای یک شب تمام قیمت کل به عنوان پیش پرداخت دریافت می‌شود. برای جزئیات بیشتر به صفحه <a href="/help/guest">«چگونه میهمان شوم؟»</a> مراجعه نمایید.</p>')
    });*/
    $('body').on('mouseup', function(e) {
        var container = $(".info-pr");
        if (!container.is(e.target) // if the target of the click isn't the container...
            && container.has(e.target).length === 0) // ... nor a descendant of the container
        {
            container.remove();
        }
    });
            var submitted = false;
            $('#submit-call').on('click', function() {
                if(!submitted)
                   $('.res-form').attr('action', $('.res-form').attr('action').replace('reserve', 'reservebytel'));
                   $('#submit').click();
                submitted = true;
            });

      
                 </script>
@extends('footer')
    