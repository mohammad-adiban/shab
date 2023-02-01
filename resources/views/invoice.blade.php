@include('header')
<html>
<head>
    <script type="text/javascript" src="{{ asset('js/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/moment-jalaali.js') }}"></script>
    <link href="{{ asset('css/trip.css?v=0.0.1') }}" rel="stylesheet">
</head>

<body>
<?php
echo '<script>console.log('.$invoice->reservation->house.')</script>';
?>
<div class="container mg-t-5">
    <div class="row" style="padding: 20px 10px">

        <!--Header-->
        <div class="col-md-10 col-md-offset-1 col-xs-12 margin-bottom-10 parts">
            <div class="boxBorder pading" style="padding-top: 10px !important; padding-bottom: 10px !important; background-color: #fbfbfb">
                <div style="display: flex; align-items: center; justify-content: space-between">

                    <div>
                        <!-- Begin Invoice ID -->
                        <div style="display: inline-block;" class="fltL">
                            <h4>کد فاکتور: {{$invoice['id']}}#</h4>
                            <span id="created_at" class="fontGray" data="{{$invoice['created_at']}}" style="font-size: 12px"></span>
                        </div>
                        <!-- End Invoice ID -->

                        <!-- Begin Logo -->
                        <div style="display: inline-block; margin-left: 5px" >
                            <img width="23px" src="/img/landing_page/logo-header.png">
                        </div>
                        <!-- End Logo -->
                    </div>

                    <!-- Begin Status Tag -->
                    <div style="display: inline-block">
                        <h5 class="flt" style="padding: 5px; border: 2px solid @if($invoice->status == 0) @if((strtotime("now") - strtotime($invoice->created_at)) / (60 * 60 * 24)>=1) red; color: red @else #aaa; color: #aaa @endif @else #62AA32; color: #62AA32 @endif">

                            @if($invoice->status == 0)
                                @if(
                                    time() > strtotime($invoice->created_at) + (60 * 60 * 24)
                                    ||
                                    $invoice->reservation->status == 5
                                    ||
                                    $invoice->reservation->status == 2
                                    ||
                                    $invoice->reservation->status == 4
                                    )
                                    <span>منقضی شده</span>
                                @elseif($invoice->reservation->status == 0)
                                    <span>منتظر تایید میزبان</span>
                                @else
                                    <span>در انتظار پرداخت</span>
                                @endif


                            @elseif($invoice->status == 1)
                                <span>پرداخت شده</span>
				<script>
                    	            window.dataLayer = window.dataLayer || []
                                    dataLayer.push({
                     	           'transactionId': {{ $invoice['id'] }},
                                   'transactionAffiliation': 'Shab',
                                   'transactionTotal': {{1000 * $invoice['total_fee']}},
                                   'transactionTax': 0,
                                   'transactionShipping': 0,
                                   'transactionProducts': [{
                        	           'sku': {{$invoice->reservation['house_id']}},
                                 	   'name': "{{$invoice->reservation->house['title']}}",
                                           'category': "{{$invoice->reservation->house['province']}}",
                                           'price': {{1000 * $invoice['total_fee']}},
                                           'quantity': {{intval(($invoice->reservation->checkout - $invoice->reservation->checkin) / 86400)}}
                                           }]
                                    });
                                </script>
                            @elseif($invoice->status == 2)
                                <span>منقضی شده</span>
                            @endif
                        </h5>
                    </div>
                    <!-- End Status Tag -->
                </div>
            </div>
        </div>


        <div class="col-md-4 col-md-offset-1 col-xs-12 margin-bottom-10 parts">
            <div class="boxBorder pading">

                <!-- Begin Checkin & Checkout Time -->
                <div>
                    <div>
                        <div class="fltL fontGray">تاریخ برگشت</div>
                        <div class="fontGray">تاریخ رفت</div>
                    </div>
                    <div class="text-center">
                        <span class="glyphicon glyphicon-chevron-left fontGray"></span>
                    </div>
                    <?php
                    $checkin = $invoice->reservation->house->rule_checkin;
                    $checkout = $invoice->reservation->house->rule_checkout;
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

                    <div>
                        <div id="checkout1" class="fltL" data="{{$invoice->reservation['checkout']}}"></div>
                        <div id="checkin1" data="{{$invoice->reservation['checkin']}}"></div>
                    </div>
                    <div>
                        <div class="fltL">
                            <span>ساعت: </span>
                            <span>{{$hours_in}}:{{$mins_in}} </span>
                        </div>
                        <div>
                            <span>ساعت: </span>
                            <span>{{$hours_out}}:{{$mins_out}}</span>
                        </div>
                    </div>
                </div>
                <!-- End Checking & Checkout Time -->

                <hr class="divider">

                <!-- Begin House Info -->
                <div>
                    @if($invoice['status'] != 1)
                        <div
                                class="invoice-house-photo"
                                style="background-image: url('/{{$invoice->reservation->house->photo->thumbnail_path}}')"
                        >
                        </div>
                    @endif
                    <h4 class="bold invoice-house-title">
                        <a
                                style="color: #484848; text-decoration: none"
                                target="_blank"
                                href="/houses/show/{{$invoice->reservation->house['id']}}"
                        >
                            {{$invoice->reservation->house['title']}}
                        </a>
                    </h4>
                    <div>
                        <span>{{$invoice->reservation->house->province}}</span> - <span>{{$invoice->reservation->house->city}}</span>
                    </div>

                    <div class="invoice-house-options">
                        <div>
                            <span>کدآگهی: </span>
                            <span>{{$invoice->reservation->house->id}}</span>
                        </div>
                        <div>
                            <span>{{$invoice->reservation->house->rooms}} اتاق</span> |

                            @if($invoice->reservation->house->detached)
                                <span>دربست</span>
                            @else
                                <span>غیربست</span>
                            @endif
                        </div>
                        <div>
                            <span>ظرفیت استاندارد:</span> <span>{{$invoice->reservation->house->accommodates}}</span> <span>نفر</span> |‌
                            <span>حداکثر ظرفیت:</span> <span>{{$invoice->reservation->house->max_accommodates}}</span> <span>نفر</span>
                        </div>
                    </div>
                </div>
                <!-- End House Info -->

                <!-- Begin Map -->
                @if($invoice['status'] == 1)
                    <p class="margin-18">{{$invoice->reservation->house['city']}}، {{$invoice->reservation->house['address']}}</p>
                    <div id="map" class="invoice-map-container"></div>
                @endif
                <!-- End Map -->

                <!-- Begin Host Info -->
                <div>
                    <div class="mrgin-top margin-bottom-3">
                        <span>میزبان: </span>
                        <span>{{$invoice->reservation->host['name']}} {{$invoice->reservation->host['family']}}</span>
                    </div>

                    @if($invoice['status'] == 1)
                        <div class="margin-bottom-3">
                            <span>تلفن: </span>
                            <a href="tel:{{$invoice->reservation->host['mobile']}}">{{$invoice->reservation->host['mobile']}}</a>
                        </div>
                    @endif
                </div>
                <!-- End Host Info -->

                <hr class="divider">

                <!-- Begin Guests Count -->
                <h4>تعداد نفرات: {{$invoice->reservation['guests']}} نفر</h4>
                <!-- End Guests Count -->

                <!-- Begin Guest Info -->
                <div class="invoice-host-info-container">
                    <!-- Begin Guest Image -->
                    @if($invoice->reservation->guest['picture'] != "")
                        <div class="profile-img">
                            <img src="/{{$invoice->reservation->guest['picture']}}" class="img-circle" />
                        </div>
                    @endif
                    <!-- End Guest Image -->

                    <!-- Begin Guest Details -->
                    <div>
                        <div class="margin-bottom-3">
                            {{$invoice->reservation->guest['name']}} {{$invoice->reservation->guest['family']}}
                        </div>

                        @if($invoice['status'] == 1)
                            <div class="margin-bottom-3">
                                <span>تلفن:</span>
                                <a href="tel:{{$invoice->reservation->guest['mobile']}}">{{$invoice->reservation->guest['mobile']}}</a>
                            </div>
                        @endif
                    </div>
                    <!-- End Guest Details -->
                </div>
                <!-- End Guest Info -->
            </div>
        </div>

        <div class="col-md-6 col-xs-12 parts">
            <div class="boxBorder pading margin-bottom-10">
                <div style="display: flex; justify-content: space-between; align-items: center">
                    <h3 style="margin-top: 0">قیمت</h3>
                </div>

                <table class="table invoice-payment-details">
                    <tbody>
                    @if($invoice->workweek_days)
                        <tr>
                            <td>روزهای وسط هفته</td>
                            <td class="float-left">
                                <span>{{$invoice->workweek_days}} روز * </span>
                                <span>{{number_format($invoice->workweek_days_price/$invoice->workweek_days * 1000)}} تومان</span>
                            </td>
                        </tr>
                    @endif

                    @if($invoice->weekend_days)
                        <tr>
                            <td>روزهای آخر هفته</td>
                            <td class="float-left">
                                <span>{{$invoice->weekend_days}} روز * </span>
                                <span>{{number_format($invoice->weekend_days_price/$invoice->weekend_days * 1000)}} تومان</span>
                            </td>
                        </tr>
                    @endif

                    @if($invoice->special_days)
                        <tr>
                            <td>روزهای خاص</td>
                            <td class="float-left">
                                <span>{{number_format($invoice->special_days_price * 1000)}} تومان</span>
                            </td>
                        </tr>
                    @endif

                    @if($invoice->extra_person)
                        <tr>
                            <td>نفر اضافه</td>
                            <td class="float-left">
                                <span>{{$invoice->extra_person}} نفر * </span>
                                <span>{{$invoice->extra_person_price/$invoice->extra_person * 1000}} تومان</span>
                            </td>
                        </tr>
                    @endif

                    @if($invoice->prepayment)
                        <tr>
                            <td>پیش پرداخت</td>
                            <td class="float-left">
                                <span>{{number_format($invoice->prepayment * 1000)}} تومان</span>
                            </td>
                        </tr>

                        <tr>
                            <td>پرداخت در محل</td>
                            <td class="float-left">
                                <span>{{number_format(($invoice->total_fee - $invoice->prepayment) * 1000)}} تومان</span>
                            </td>
                        </tr>
                    @endif

                    @if(Auth::user()->id == $invoice->reservation->host_user_id)
                        <tr>
                            <td>حق سرویس سایت شب</td>
                            <td class="float-left">
                                <span>{{number_format(($invoice->total_fee/10) * 1000)}} تومان</span>
                            </td>
                        </tr>
                    @endif

                    {{--<tr>--}}
                    {{--<td>تخفیف</td>--}}
                    {{--<td class="float-left">--}}
                    {{--<span>{{number_format(($invoice->total_fee/10) * 1000)}} تومان</span>--}}
                    {{--</td>--}}
                    {{--</tr>--}}
                    </tbody>
                </table>
                <table class="table @if($invoice['status'] != 1) grayBG @else payedState @endif">
                    <tbody>
                    <tr>
                        <td>هزینه کل</td>
                        <td style="text-align: left">
                            @if(Auth::user()->id == $invoice->reservation->host_user_id)
                                <span>{{number_format(((9*$invoice->total_fee)/10) * 1000)}} تومان</span>
                            @else
                                <span>{{number_format($invoice->total_fee * 1000 )}} تومان</span>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>

                {{--<div class="offer-container">--}}
                {{--<label>کد تخفیف: </label>--}}
                {{--<input type="text" placeholder="مثلا: shab123"/>--}}
                {{--<button id="offer-btn">اعمال</button>--}}
                {{--</div>--}}
                @if(
                    $invoice['status'] == 0 &&
                    $invoice->reservation->status == 1 &&
                    Auth::user()->mobile == $invoice->reservation->guest->mobile &&
                    (strtotime("now") - strtotime($invoice->created_at))/(60 * 60 * 24) < 1
                )
                    <hr class="divider margin-30">

                    <div class="invoice-payment-container">
                        <div>
                            <div data="2" class="invoice-payment-logo-container">
                                <img width="55px" src="/img/zarin.png"/>
                            </div>

                            {{--<div data="3" class="invoice-payment-logo-container">--}}
                            {{--<img width="70px" src="/img/asanpardakht_pgw.png"/>--}}
                            {{--</div>--}}

                            <div data="1" class="invoice-payment-logo-container invoice-active-payment-logo-container">
                                <img width="55px" src="/img/ayandeh_pgw.png"/>
                            </div>
                        </div>

                        <div>
                            <button id="paymentBtn" class="btn float-left btn-success invoice-paymen-btn">
                                <i class="fa fa-credit-card"></i> پرداخت
                            </button>
                        </div>
                    </div>

                    <div>
                        <p>
                            همچنین شما میتوانید وجه فوق را به کارت زیر واریز و کد پیگیری را به شماره
                            <a href="tel:1007892">۱۰۰۰۷۸۹۲</a>
                            ارسال نمایید:
                        </p>
                        <p>
                            6362-1470-1000-0766
                            <br>
                            شرکت وندا رایمند
                        </p>
                    </div>
                @endif
            </div>


            <div class="boxBorder pading margin-bottom-10">
                <h3 style="margin-top: 0">قوانین خانه</h3>

                <div class="row" style="margin-top: 15px">
                    <div class="col-xs-12 col-sm-6" style="padding-left: 3px; margin-bottom: 3px;">
                        <span>امکان ورود حیوانات خانگی: </span>
                        <span> @if($invoice->reservation->house['rule_pets']) دارد @else ندارد @endif </span>
                    </div>
                    <div class="col-xs-12 col-sm-6" style="padding-left: 3px; margin-bottom: 3px;">
                        <span>امکان برگزاری مهمانی: </span>
                        <span>@if($invoice->reservation->house['rule_cermony']) دارد @else ندارد @endif</span>
                    </div>

                    @if($invoice->reservation->house['rules_desc'] != '')
                        <div class="col-xs-12">
                            <span style="font-weight: 500">توضیحات: </span>
                            <span>{{$invoice->reservation->house['rules_desc']}}</span>
                        </div>
                    @endif
                </div>

                <div style="margin-top: 20px">
                    <h5 style="margin-bottom: 5px">قوانین لغو رزرو: </h5>
                    <div>- بیش از ۴۸ساعت مانده به شروع اقامت: بازگشت کل مبلغ ودیعه بدون کسر هیچ مبلغی</div>
                    <div>- کمتر از ۴۸ساعت مانده به شروع اقامت: کسر مبلغ شب اول رزرو و بازگشت باقیمانده وجه</div>
                </div>
            </div>

        </div>
    </div>
</div>
@include('footer')
</body>
</html>
<script type="text/javascript">
    $(document).ready(function () {
        initMap()

        $('#checkin1').text(digitsToHindi(moment.unix($('#checkin1').attr('data')).utc().format("jYYYY/jMM/jDD")));
        $('#checkout1').text(digitsToHindi(moment.unix($('#checkout1').attr('data')).utc().format("jYYYY/jMM/jDD")));
        $('#created_at').text(digitsToHindi(moment($('#created_at').attr('data') , 'YYYY-MM-DD HH:mm:ss').utc().format("HH:mm jYYYY/jMM/jDD")));

        $('.invoice-payment-logo-container').click(function () {
            $('.invoice-active-payment-logo-container').removeClass('invoice-active-payment-logo-container');
            $(this).addClass('invoice-active-payment-logo-container');
        });

    });

    $("#paymentBtn").click(function(){
        var data = {
            credit: parseInt("{{$invoice->prepayment}}"),
            invoice: parseInt("{{$invoice->id}}"),
            pgw: $('.invoice-active-payment-logo-container').attr('data')
        };
        console.log(data);
        $.ajax({
            contentType: "application/json",
            //dataType: "json",
            type: 'POST',
            url: "/payments/charge",
            data: JSON.stringify(data),
            success: function(result){
                console.log(result);
                if(result.status == 'success')
                    if(data.pgw == 2)
                        window.location.href = 'https://www.zarinpal.com/pg/StartPay/'+result.url.Authority;
                    else
                        postRefId (result.url);
            }
        });
    });

    function postRefId (refIdValue) {
        var form = document.createElement("form");
        form.setAttribute("method", "POST");
        form.setAttribute("action", "https://bpm.shaparak.ir/pgwchannel/startpay.mellat");
        form.setAttribute("target", "_self");
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("name", "RefId");
        hiddenField.setAttribute("value", refIdValue);
        form.appendChild(hiddenField);

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }

</script>

<script>
    function initMap() {
        var uluru = {lat: parseFloat("{{$invoice->reservation->house['latitude']}}") , lng: parseFloat("{{$invoice->reservation->house['longitude']}}") };
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 14,
            center: uluru,
            disableDefaultUI: true,
            fullscreenControl: true
        });
        var marker = new google.maps.Marker({
            position: uluru,
            map: map
        });
    }

    $('.offer-container input').keyup(function () {
        console.log('renrgiknm')
        if($(this).val()) {
            $('#offer-btn').addClass('active');
        } else {
            $('#offer-btn').removeClass('active');
        }
    })
</script>
