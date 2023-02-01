@include('header')
<?php
    //if invoice id is null => redirect
    if($reservation['invoice_id'] == null) {
        //redirect to my reservation, if user is host
        if($reservation->host['id'] == Auth::user()->id)
            header("Location: /my_reservations");
        //redirect to trips, if user is guest
        elseif($reservation->guest['id'] == Auth::user()->id)
            header("Location: /trips");
        die();
    }
?>
<script type="text/javascript" src="{{ asset('js/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/moment-jalaali.js') }}"></script>
<link href="{{ asset('css/trip.css') }}" rel="stylesheet">

<body>
<input type="hidden" id="rID" value="{{$reservation->id}}">
<div class="container mg-t-7 parts" style="padding: 10px">
    <aside class="col-sm-12 col-md-4 asideBar boxBorder" style="margin-bottom: 10px">

        <div class="row text-center">
            <a href="#">
                <img class="img-circle img-center" src="
                @if($reservation->guest['picture'] == '' || $reservation->host['picture'] == '')
                        /img/user-default.png
                @else
                    @if($reservation->guest['id'] == Auth::user()->id) /{{$reservation->host['picture']}}
                    @elseif($reservation->host['id'] == Auth::user()->id) /{{$reservation->guest['picture']}}
                    @endif
                @endif" alt="profile picture">
            </a>
            <h4 class="text-center">
                @if($reservation->guest['id'] == Auth::user()->id){{$reservation->host['name']}} {{$reservation->host['family']}}
                @elseif($reservation->host['id'] == Auth::user()->id){{$reservation->guest['name']}} {{$reservation->guest['family']}}
                @endif
            </h4>
            @if($reservation->invoice->status == 1)
                <a href="tel:">
                    <h5 class="fontGray">
                        @if($reservation->guest['id'] == Auth::user()->id){{$reservation->host->mobile}}
                        @elseif($reservation->host['id'] == Auth::user()->id){{$reservation->guest->mobile}}
                        @endif
                    </h5>
                </a>
                @if($reservation->guest['id'] == Auth::user()->id)
                    <h5 class="fontGray">{{$reservation->house->city}}، {{$reservation->house->address}}</h5>
                @endif
            @endif
        </div>

        <hr class="divider mrgin-top">

        <div class="continer">
            <div>
                <div class="fltL fontGray">تاریخ برگشت</div>
                <div class="fontGray">تاریخ رفت</div>
            </div>

            <div class="text-center"><span class="glyphicon glyphicon-chevron-left fontGray"></span></div>

            <div>
                <div class="fltL" id="checkout1" value="{{$reservation->checkout}}"></div>
                <div id="checkin1" value="{{$reservation->checkin}}"></div>
            </div>

            <hr class="divider">

            <table class="table mrgin-top reservation-payment-details-table">
                <tbody>
                <tr>
                    <th>روزهای وسط هفته</th>
                    <th>
                        @if($reservation->invoice->workweek_days == 0) - @else {{$reservation->invoice->workweek_days}} روز * {{$reservation->invoice->workweek_days_price/$reservation->invoice->workweek_days}}000 تومان@endif
                    </th>
                </tr>
                <tr>
                    <th>روزهای آخر هفته</th>
                    <th>
                        @if($reservation->invoice->weekend_days == 0) - @else {{$reservation->invoice->weekend_days}} روز * {{$reservation->invoice->weekend_days_price/$reservation->invoice->weekend_days}}000 تومان@endif
                    </th>
                </tr>
                <tr>
                    <th>روزهای خاص</th>
                    <th>
                        @if($reservation->invoice->special_days == 0) - @else {{$reservation->invoice->special_days * $reservation->invoice->special_days_price}}000 تومان@endif
                    </th>
                </tr>
                <tr>
                    <th>نفر اضافه</th>
                    <th>
                        @if($reservation->invoice->extra_person == 0) - @else {{$reservation->invoice->extra_person}} نفر * {{$reservation->invoice->extra_person_price/$reservation->invoice->extra_person}}000 تومان@endif
                    </th>
                </tr>

                <tr>
                    <th class="bold">مبلغ کل</th>
                    <th class="bold">
                        {{$reservation->invoice->total_fee}}000 تومان
                    </th>
                </tr>
                </tbody>
            </table>
        </div>

        <a target="_blank" class="btn send-btn" style="width: 100%; font-weight: bold; border-width: 2px" href="{{asset('invoices/'.$reservation->invoice->id.'/show')}}">
            <span> مشاهده فاکتور</span>
            @if($reservation->guest['id'] == Auth::user()->id && $reservation->status == 1)<span>و پرداخت</span>@endif
        </a>
    </aside>

    <div class="col-md-1"></div>

    <section class="col-sm-12 col-md-7 no-padding">
        <div class="container boxBorder text-justify boxWidth">
                {{--<h4>درخواست لغو</h4>--}}
                {{--<p>ما باید تنظیماتی را برای کنترل بیشتری بر رزرو شما انجام دهیم:</p>--}}
                {{--<ul>--}}
                    {{--<li>اجتناب از رزرو دو برابر شده توسط <a href="#">همگام سازی تقویم های شما</a> </li>--}}
                    {{--<li>وقت خود را به اندازه کافی اختصاص دهید تا با تنظیم خود آماده شوید <a href="#">هشدار</a> </li>--}}
                    {{--<li>سفر خود را که با تنظیم شما مناسب است، دریافت کنید <a href="#">حداقل یا حداکثر شبها</a> </li>--}}
                    {{--<li>اجتناب از سفر که در آینده با تنظیم خود شما خیلی دور است <a href="#">پنجره رزرو</a></li>--}}
                {{--</ul>--}}
                {{--<p>اگر شما در حال میزبانی در ۲۹ ژوئن - ۰۳ ژوئیه هستید، میتوانید تاریخ را باز کنید <a href="#">تقویم شما</a> </p>--}}

                <div>
                    <div style="margin-bottom: 10px; text-align: center">
                        @if($reservation->guest['id'] == Auth::user()->id)
                            @if($reservation->status == 0)
                                منتظر تایید میزبان، لطفا با انتخاب گزینه‌ی زیر درخواست رزرو را لغو نمایید
                            @elseif($reservation->status == 1)
                                منتظر پرداخت توسط شما، لطفا با انتخاب گزینه‌ی زیر درخواست رزرو را لغو نمایید
                            @elseif($reservation->status == 2)
                                <strong>! وضعیت درخواست: </strong>رد خواست توسط میزبان

                            @elseif($reservation->status == 3)
                                <strong>! وضعیت درخواست: </strong> درخواست نهایی شده است

                            @elseif($reservation->status == 4)
                                <strong>! وضعیت درخواست: </strong>منقضی شده است

                            @elseif($reservation->status == 5)
                                <strong>! وضعیت درخواست: </strong>رد خواست توسط شما

                            @endif
                        @elseif($reservation->host['id'] == Auth::user()->id)
                            @if($reservation->status == 0)
                                لطفا با انتخاب گزینه‌های زیر وضعیت درخواست رزرو را مشخص نمایید
                            @elseif($reservation->status == 1)
                                <strong>! وضعیت درخواست: </strong> در انتظار پرداخت وجه از طرف مهمان

                            @elseif($reservation->status == 2)
                                <strong>! وضعیت درخواست: </strong>رد خواست توسط شما

                            @elseif($reservation->status == 3)
                                <strong>! وضعیت درخواست: </strong> درخواست نهایی شده است

                            @elseif($reservation->status == 4)
                                <strong>! وضعیت درخواست: </strong>منقضی شده است

                            @elseif($reservation->status == 5)
                                <strong>! وضعیت درخواست: </strong>رد خواست توسط مهمان
                            @endif
                        @endif
                    </div>

                    <div style="display: flex; justify-content: center;">
                        @if($reservation->guest['id'] == Auth::user()->id)
                            @if($reservation->status == 0 || $reservation->status == 1)
                                <div id="cancel-reserve-btn" class="btn send-btn" style="width: 130px; margin: 3px; background-color: #ececec; border-width: 2px; font-weight: bold">
                                    <i class="fa fa-ban" aria-hidden="true"></i> لغو درخواست
                                </div>
                                @if($reservation->status == 1)
                                    <a  href="{{asset('invoices/'.$reservation->invoice->id.'/show')}}" target="_blank">
                                        <div id="pay-reserve-btn" class="btn send-btn" style="width: 130px; margin: 3px; background-color: #ececec; border-width: 2px; font-weight: bold">
                                            <i class="fa fa-credit-card" aria-hidden="true"></i> پرداخت
                                        </div>
                                    </a>
                                @endif
                            @endif
                        @elseif($reservation->host['id'] == Auth::user()->id)
                            @if($reservation->status == 0)
                                <div onclick="acceptOrReject('accept')" class="btn send-btn" style="width: 130px; margin: 3px; background-color: #ececec; border-width: 2px; font-weight: bold">
                                    <i class="fa fa-check-circle" aria-hidden="true"></i> قبول می‌کنم
                                </div>
                                <div onclick="acceptOrReject('reject')" class="btn send-btn" style="width: 130px; margin: 3px; background-color: #ececec; border-width: 2px; font-weight: bold">
                                    <i class="fa fa-ban" aria-hidden="true"></i> رد می‌کنم
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
        </div>

        <div class="comment">
            {{--<a href="#"><img class="img-circle commentImg" src="/{{$reservation->guest['picture']}}"></a>--}}
            {{--<div class="talkbubble-message big">--}}
            {{--<textarea id="input-msg" class="input-msg"></textarea>--}}
            {{--<div class="send grayBG">--}}
            {{--<button id="send-msg-btn" class="btn send-btn"> ارسال پیام</button>--}}
            {{--<!-- <a class="fltL pding-top" href="#">استفاده از پیام ذخیره</a> -->--}}
            {{--</div>--}}
            {{--</div>--}}

            <div class="reservation-message-container">
                <div class="reservation-message-photo-container reservation-message-photo-container-reply">
                    <img src="@if(Auth::user()->picture != "") /{{Auth::user()->picture}} @else /img/user-default.png @endif">
                </div>
                <div class="talkbubble-message" style="padding: 0">
                    <div style="padding: 15px">
                        <textarea id="input-msg" class="input-msg"></textarea>
                    </div>

                    <div class="send grayBG">
                        <button id="send-msg-btn" class="btn send-btn"> ارسال پیام</button>
                        <!-- <a class="fltL pding-top" href="#">استفاده از پیام ذخیره</a> -->
                    </div>

                </div>
            </div>
        </div>

        <div id="msg" class="comment">
            {{--<a href="#"><img class="img-circle commentImg" src="/img/user-default.png"></a>--}}
            {{--<div class="talkbubble-reply grayBG">--}}
            {{--<p>با عرض پوزش، فراموش کردم که تقویم را غیرفعال کنم</p>--}}
            {{--<span class="dateColor">۱ تیر , ۱۳۹۶</span>--}}
            {{--</div>--}}

            {{--<div style="display: flex; align-items: flex-start; margin-bottom: 15px">--}}
            {{--<div class="talkbubble-reply grayBG">--}}
            {{--<div>--}}
            {{--سلام--}}
            {{--</div>--}}
            {{--<div id="an" class="reservation-message-date fontGray" value="2017-11-29 16:47:43">--}}
            {{--۲/۰۶/۹۶--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="reservation-message-photo-container">--}}
            {{--<img src="/img/user-default.png">--}}
            {{--</div>--}}
            {{--</div>--}}

        </div>
    </section>

</div>
@include('footer')
</body>

<script type="text/javascript">
    var pageNum = 1;
    var newestMessage = -1;
    var oldestMessage = -1;

    $("#cancel-reserve-btn").click(function () {
        $.ajax({
            contentType: "application/json",
            dataType: "json",
            type: 'POST',
            url: "/reservations/{{$reservation->id}}/cancel",
            success: function(result){
                if(result.status == 'success')
                    location.reload();
            }
        });
    })

    function acceptOrReject (input){
        $.ajax({
            contentType: "application/json",
            dataType: "json",
            type: 'POST',
            url: "/reservations/{{$reservation->id}}/"+input,
            success: function(result){
                if(result.status == 'success')
                    location.reload();
            }
        });
    }

    function makeReplyMessage (data) {
        var photo = "";
        if ( data.from_user_id == {{$reservation->guest['id']}} )
            photo = "/{{$reservation->guest['picture']}}";
        else if ( data.from_user_id == {{$reservation->host['id']}} )
            photo = "/{{$reservation->host['picture']}}";
        if (photo == "/")
            photo = "/img/user-default.png";

        var txt =
            '<div class="reservation-message-container">' +
                '<div class="talkbubble-reply grayBG">' +
                    '<div>' +
                        data.text +
                    '</div>' +
                    '<div id="date_message_' + data.id + '" class="reservation-message-date fontGray" value="' + data.created_at + '">' +
                    '</div>' +
                '</div>' +
                '<div class="reservation-message-photo-container reservation-message-photo-container-message">' +
                    '<img src="' + photo + '">' +
                '</div>' +
            '</div>';

        return txt;
    }

    function makeMyMessage (data) {
        var txt =
            '<div class="reservation-message-container">' +
                '<div class="reservation-message-photo-container reservation-message-photo-container-reply">' +
                    '<img src="@if(Auth::user()->picture != "") /{{Auth::user()->picture}} @else /img/user-default.png @endif">' +
                '</div>' +
                '<div class="talkbubble-message">' +
                    '<div>' +
                        data.text +
                    '</div>' +
                    '<div style="left: 15px" id="date_message_' + data.id + '" class="reservation-message-date fontGray" value="' + data.created_at + '">' +
                    '</div>' +
                '</div>' +
            '</div>';

        return txt;
    }


    function getMessages(pageIndex) {
        $.ajax({
            type: "POST",
            url: "/messaging/get",
            data: 'reservation=' + $('#rID').val() + '&page='+pageIndex,
            success: function (res) {
                $("#loadMoreMessage").remove();
                if (res.total > 0) {
                    var data = res.data;
                    var currentUser = {{ Auth::user()->id }};
                    var idArray = [];

                    for (var i = 0; i < res.data.length; i++) {
                        if (data[i].id < oldestMessage || oldestMessage == -1) {
                            if (data[i].from_user_id != currentUser) {
                                $("#msg").append(makeReplyMessage(data[i]));
                                idArray.push(data[i].id);
                            }
                            else
                                $("#msg").append(makeMyMessage(data[i]));

                            oldestMessage = data[i].id;
                        }

                        else if (data[i].id > newestMessage) {
                            if (pageIndex != 1) {
                                if (data[i].from_user_id != currentUser) {
                                    $("#msg").prepend(makeReplyMessage(data[i]));
                                    idArray.push(data[i].id);
                                }
                                else
                                    $("#msg").prepend(makeMyMessage(data[i]));

                                newestMessage = data[i].id;
                            }
                            else {
                                var newArray = [];
                                while (data[i].id > newestMessage) {
                                    if (data[i].from_user_id != currentUser) {
                                        newArray.push(makeReplyMessage(data[i]));
                                        idArray.push(data[i].id);
                                    }
                                    else
                                        newArray.push(makeMyMessage(data[i]));
                                    i++;
                                }
                                $("#msg").prepend(newArray);
                            }
                        }

                        $("#date_message_" + data[i].id).text(digitsToHindi(moment($("#date_message_" + data[i].id).attr('value'), 'YYYY-M-D HH:mm:ss').format('jYYYY/jM/jD HH:mm')));
                    }

                    if (pageIndex == 1)
                        newestMessage = res.data[0].id;


                    if (idArray.length != 0) {
                        var temp = {messages: idArray, reservation: {{$reservation->id}}};
                        $.ajax({
                            contentType: "application/json",
                            type: "POST",
                            url: "/messaging/seen",
                            data: JSON.stringify(temp),
                            success: function (result) {

                            }
                        });
                    }

                    if (res.total > 30 * pageNum)
                        $('#msg').append(
                            '<div onclick="getMessages(' + (++pageNum) + ')" id="loadMoreMessage" class="btn send-btn" style="width: 100%; font-weight: bold; border-width: 2px; border-color: #dcdcdc">\n' +
                                '<span> پیام‌های قدیمی‌تر</span>\n' +
                            '</div>'
                        );
                }
            },

            error: function (error) {
                if(error.status == 401)
                    location.reload();
            }
        });
    }


    $(document).ready(function () {
        $('#checkin1').text(digitsToHindi(moment.unix($('#checkin1').attr('value')).utc().format("jYYYY/jMM/jDD")));
        $('#checkout1').text(digitsToHindi(moment.unix($('#checkout1').attr('value')).utc().format("jYYYY/jMM/jDD")));

        getMessages(1);
        setInterval(function() {pageNum--; getMessages(1)}, 5000)

        $("#send-msg-btn").click(function () {
            var d = new Date();
            var n = d.getTime();
            var x = $("#input-msg").val();
            $.ajax({
                type: "POST",
                url: "/messaging/send",
                data: 'reservation='+$('#rID').val()+'&text='+x,
                success: function(result) {
                    if(result.status == 'success') {
                        pageNum--;
                        getMessages(1);
                        $("#input-msg").val("");
                    }
                }
            });
        });
        
        $("#input-msg").keydown(function (e) {
            if (e.keyCode == 13 && !e.shiftKey) {
                e.preventDefault();
                $("#send-msg-btn").click();
            }
        })
    });
</script>
