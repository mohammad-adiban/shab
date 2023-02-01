<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/myTrips.css?v=0.0.2') }}">


<div class="main-user">
    <div class="container room user-panel">
        <div class="col-xs-12 col-lg-10 col-lg-offset-1 padding-xs-0">

            @if(session('review') == 'OK' || session('review-edit') == 'OK')
                <div id="review-error-alert" class="col-xs-12" style="margin: 0 0 15px 0; padding: 0">
                    <div class="alert alert-success alert-dismissable fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <span id="reviewResultAlert"> نظر شما با موفقیت
                            @if(session('review') == 'OK') ثبت شد
                            @elseif(session('review-edit') == 'OK') ویرایش گردید
                            @endif
                        </span>
                    </div>
                </div>
            @endif

            <div class="col-xs-12 col-sm-12 padding-xs-0">
                <div class="panel space-4">
                    <div class="panel-header" style="font-size: 18px; font-weight: 700">
                        لیست سفرهای من
                    </div>
                    <ul class="list-unstyled myhouses col-xs-12 allTripsContainer" style="background-color: #fff; padding: 10px 0;">
                        <!--no trips-->
                        @if($trips->isEmpty())
                            <p class="panel-body" style="text-align: center">لیست شما خالی است.</p>
                        @else
                            <?php $noItems_invoice_id = true; ?>
                            @foreach($trips as $trip)
                                @if($trip->invoice_id != null)
                                    <?php $noItems_invoice_id = false;
                                        echo '<script>console.log('.$trip->invoice.')</script>'
                                    ?>
                                    <li class="col-xs-12" style="padding: 0; margin: 0; z-index: 1">
                                        <div class="myTrips-items-extraInfo hidden">
                                            <span>
                                                <span>شناسه رزرو: </span>
                                                <span>{{$trip->id}}</span>
                                            </span>

                                            <span>
                                                <span class="create-time" value="{{$trip->invoice->created_at}}"></span>
                                            </span>
                                        </div>

                                        <div class="myTrips-items-container">
                                            <!-- Begin Image Container -->
                                            <div class="img-container">
                                                <div>
                                                    <img src="{{$trip->house->photo['thumbnail_path']}}">
                                                </div>
                                            </div>
                                            <!-- End Image Container -->


                                            <!-- Begin Bookmark -->
                                            <div
                                                class="item-favorite-container"
                                                title="علاقه‌مندی‌ها"
                                                data-bookmarked="{{$trip->house->bookmarked}}"
                                                data-houseId="{{$trip->house->id}}"
                                            >
                                                <div class="item-favorite">
                                                    <i class="fa fa-heart @if($trip->house->bookmarked) active @endif"></i>
                                                    <i class="fa fa-heart-o"></i>
                                                </div>
                                            </div>
                                            <!-- End Bookmark -->


                                            <!--Begin Info Container -->
                                            <div class="info-container">

                                                <!-- Begin House, Host & Trip Info -->
                                                <div class="main-info-container">

                                                    <!-- Begin House Info -->
                                                    <div class="house-info-container">
                                                        <div>
                                                            <h4 class="col-xs-8">
                                                                <a href="/houses/show/{{$trip->house->id}}">
                                                                    <span>{{$trip->house->title}}</span>
                                                                </a>
                                                            </h4>


                                                            <div class="house-code-container col-xs-4">
                                                                <span>
                                                                    <a href="houses/show/{{$trip->house->id}}">
                                                                        <span>کد آگهی:  </span>
                                                                        <span>{{$trip->house->id}}</span>
                                                                    </a>
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <div class="location-info-container">
                                                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                                <span>استان </span>
                                                                <span>{{$trip->house->province}}</span>
                                                                <span> - </span>
                                                                <span>{{$trip->house->city}}</span>
                                                            </div>

                                                            <?php
                                                            $rate = 0;
                                                            if($trip->house->statistics) {
                                                                $statistics = $trip->house->statistics;
                                                                $rate =
                                                                    ($statistics->accessibility +
                                                                        $statistics->accuracy +
                                                                        $statistics->cleanliness +
                                                                        $statistics->host +
                                                                        $statistics->neighborhood +
                                                                        $statistics->neighborhood) * 100 / 30;
                                                            }
                                                            ?>
                                                            <div class="star-ratings-css" >
                                                                <div class="star-ratings-css-top" style="width: {{$rate}}%"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
                                                                <div class="star-ratings-css-bottom"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
                                                            </div>
                                                        </div>


                                                        <div class="hidden-xs">
                                                            <div class="host-info-container">
                                                                <img src="@if($trip->host['picture'] != '') {{ $trip->host['picture'] }} @else /img/user-default.png @endif" />
                                                                <span>{{$trip->host->family}}</span>
                                                            </div>

                                                            <div class="button-container">
                                                                @if($trip['status'] == 3 && time()>$trip['checkout'])
                                                                    <a id="trips-btn-reviewNew-{{$trip->id}}" href="/reservations/{{$trip->id}}/reviews/new">
                                                                        <button>ثبت‌نظر</button>
                                                                    </a>
                                                                @else
                                                                    <a id="trips-btn-chat-{{$trip->id}}" href="/reservations/{{$trip->id}}/show">
                                                                        <button>گفتگو با میزبان</button>
                                                                    </a>
                                                                @endif

                                                                <a id="trips-btn-reviewEdit-{{$trip->id}}" href="" style="display: none">
                                                                    <button>ویرایش نظر</button>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End House Info -->


                                                    <!-- Begin House & Trip Info -->
                                                    <div class="trip-host-info-container">

                                                        <!-- Begin Host Info -->
                                                        <div class="host-info-container visible-xs">
                                                            <div class="host-info">
                                                                <div class="personal-info">
                                                                    <img src="@if($trip->host['picture'] != '') {{ $trip->host['picture'] }} @else /img/user-default.png @endif">
                                                                    <span class="name">{{$trip->host->family}}</span>
                                                                </div>

                                                                <div>
                                                                    @if($trip['status'] == 3 && time()>$trip['checkout'])
                                                                        <a id="trips-btn-reviewNew-{{$trip->id}}" href="/reservations/{{$trip->id}}/reviews/new">
                                                                            <button>ثبت‌نظر</button>
                                                                        </a>
                                                                    @else
                                                                        <a id="trips-btn-chat-{{$trip->id}}" href="/reservations/{{$trip->id}}/show">
                                                                            <button>گفتگو با میزبان</button>
                                                                        </a>
                                                                    @endif

                                                                    <a id="trips-btn-reviewEdit-{{$trip->id}}" href="" style="display: none">
                                                                        <button>ویرایش نظر</button>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End  Host Info -->


                                                        <!-- Begin Trip Info -->
                                                        <div class="trip-info-container">
                                                            <div class="text-trip-info">
                                                                <div>
                                                                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                                                                    <span class="checkinR" value="{{$trip->checkin}}"></span>
                                                                    <span> - </span>
                                                                    <span class="checkoutR" value="{{$trip->checkout}}"></span>
                                                                </div>

                                                                <div>
                                                                    <span>قیمت نهایی: </span>
                                                                    <span style="font-weight: 900; color: #000000">{{number_format($trip->invoice->total_fee * 1000)}}</span>
                                                                    <span> تومان </span>
                                                                </div>
                                                            </div>


                                                            <div class="payment-info">
                                                                @if(
                                                                    ($trip->status == 0  && time() > strtotime($trip->invoice->created_at) + (24*60*60))
                                                                    ||
                                                                    ($trip->status == 1  && time() > strtotime($trip->invoice->updated_at) + (24*60*60))
                                                                )
                                                                    @if(time() > $trip->checkin)
                                                                        <a href="/houses/show/{{$trip->house->id}}">
                                                                            <button class="invoice-btn">
                                                                                <span>
                                                                                    <i class="fa fa-repeat" aria-hidden="true"></i>
                                                                                </span>
                                                                                <span>درخواست مجدد</span>
                                                                            </button>
                                                                        </a>
                                                                    @else
                                                                        <a href="/houses/reserve/{{$trip->house->id}}?checkin={{$trip->checkin}}&checkout={{$trip->checkout}}&accomodates={{$trip->guests}}">
                                                                            <button class="invoice-btn">
                                                                                <span>
                                                                                    <i class="fa fa-repeat" aria-hidden="true"></i>
                                                                                </span>
                                                                                <span>درخواست مجدد</span>
                                                                            </button>
                                                                        </a>
                                                                    @endif

                                                                @elseif($trip->status == 0)
                                                                    <a href="/invoices/{{$trip->invoice_id}}/show">
                                                                        <button class="invoice-btn">
                                                                            <span>
                                                                                <i class="fa fa-file-text" aria-hidden="true"></i>
                                                                            </span>
                                                                            <span>رسید سفر</span>
                                                                        </button>
                                                                    </a>


                                                                @elseif($trip->status == 1)
                                                                    <a href="/invoices/{{$trip->invoice_id}}/show">
                                                                        <button class="invoice-btn pay">
                                                                            <span>
                                                                                <i class="fa fa-credit-card" aria-hidden="true"></i>
                                                                            </span>
                                                                            <span>پرداخت</span>
                                                                        </button>
                                                                    </a>

                                                                @elseif($trip->status == 2)
                                                                    <a href="/search/city/{{$trip->house->city}}">
                                                                        <button class="invoice-btn search">
                                                                            <span>
                                                                                <i class="fa fa-search" aria-hidden="true"></i>
                                                                            </span>
                                                                            <span>ویلاهای مشابه</span>
                                                                        </button>
                                                                    </a>

                                                                @elseif($trip->status == 3)
                                                                    <a href="/invoices/{{$trip->invoice->id}}/show">
                                                                        <button class="invoice-btn pay">
                                                                            <span>
                                                                                <i class="fa fa-check" aria-hidden="true"></i>
                                                                            </span>
                                                                            <span>مشاهده رسید</span>
                                                                        </button>
                                                                    </a>

                                                                @elseif($trip->status == 4)
                                                                    <a href="/houses/reserve/{{$trip->house->id}}?checkin={{$trip->checkin}}&checkout={{$trip->checkout}}&accomodates={{$trip->guests}}">
                                                                        <button class="invoice-btn search">
                                                                            <span>
                                                                                <i class="fa fa-search" aria-hidden="true"></i>
                                                                            </span>
                                                                            <span>ویلاهای مشابه</span>
                                                                        </button>
                                                                    </a>

                                                                @elseif($trip->status == 5)
                                                                    <a href="/search/city/{{$trip->house->city}}">
                                                                        <button class="invoice-btn search">
                                                                            <span>
                                                                                <i class="fa fa-search" aria-hidden="true"></i>
                                                                            </span>
                                                                            <span>ویلاهای مشابه</span>
                                                                        </button>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <!-- End Trip Info -->
                                                    </div>
                                                    <!-- End House & Trip Info -->
                                                </div>
                                                <!-- End House, Host & Trip Info -->


                                                <!-- Begin Step Bar -->
                                                <div class="step-bar">
                                                    <ul class="progressbar">
                                                        @if(
                                                            ($trip->status == 0  && time() > strtotime($trip->invoice->created_at) + (24*60*60))
                                                            ||
                                                            ($trip->status == 1  && time() > strtotime($trip->invoice->updated_at) + (24*60*60))
                                                        )
                                                            <li class="deactive">
                                                                <span class="progressbar-wrapper">ثبت درخواست
                                                                    <div class="progressbar-tooltip">
                                                                    <span>درخواست شما ثبت گردید و در حال پیگیری است</span>
                                                                    </div>
                                                                </span>
                                                            </li>

                                                            <li class="deactive">
                                                            </li>

                                                            <li class="deactive">
                                                            </li>

                                                            <li class="deactive">
                                                                <span class="progressbar-wrapper">
                                                                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                    <span>منقضی شده</span>

                                                                    <div class="progressbar-tooltip">
                                                                        <span>مدت زمان اعتبار این درخواست تمام شده است</span>
                                                                    </div>
                                                                </span>
                                                            </li>

                                                        @elseif($trip->status == 0)
                                                            <li class="active">
                                                                <span class="progressbar-wrapper">
                                                                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                    <span>ثبت درخواست</span>

                                                                    <div class="progressbar-tooltip">
                                                                        <span>درخواست شما به میزبان ارسال شده و در انتظار تایید است</span>
                                                                    </div>
                                                                </span>
                                                            </li>

                                                            <li>
                                                                <span class="progressbar-wrapper">
                                                                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                    <span>تایید میزبان</span>

                                                                    <div class="progressbar-tooltip">
                                                                        <span>پاسخ درخواست به وسیله پیامک به شما ارسال می‌شود</span>
                                                                    </div>
                                                                </span>
                                                            </li>

                                                            <li>
                                                                <span class="progressbar-wrapper">
                                                                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                    <span>پیش‌پرداخت</span>

                                                                    <div class="progressbar-tooltip">
                                                                        <span>قبل از پرداخت، می‌توانید با میزبان گفتگو و سوالات خود را مطرح کنید</span>
                                                                    </div>
                                                                </span>
                                                            </li>

                                                            <li>
                                                                <span class="progressbar-wrapper">
                                                                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                    <span>تحویل کلید</span>

                                                                    <div class="progressbar-tooltip">
                                                                        <span>کلید در محل آدرس اقامتگاه توسط هماهنگ‌کننده به شما تحویل داده خواهد شد</span>
                                                                    </div>
                                                                </span>
                                                            </li>

                                                        @elseif($trip->status == 1)
                                                            <li class="active">
                                                                <span class="progressbar-wrapper">ثبت درخواست
                                                                    {{--<div class="progressbar-tooltip">--}}
                                                                        {{--<span>درخواست شما ثبت گردید و در حال پیگیری است</span>--}}
                                                                    {{--</div>--}}
                                                                </span>
                                                            </li>

                                                            <li class="active">
                                                                <span class="progressbar-wrapper">
                                                                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                    <span>تایید میزبان</span>

                                                                    <div class="progressbar-tooltip">
                                                                        <span>با پرداخت ودیعه، درخواست خود را نهایی کنید</span>
                                                                    </div>
                                                                </span>
                                                            </li>

                                                            <li>
                                                                <span class="progressbar-wrapper">
                                                                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                    <span>پیش‌پرداخت</span>

                                                                    <div class="progressbar-tooltip">
                                                                        <span>قبل از پرداخت، می‌توانید با میزبان گفتگو و سوالات خود را مطرح کنید</span>
                                                                    </div>
                                                                </span>
                                                            </li>

                                                            <li>
                                                                <span class="progressbar-wrapper">
                                                                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                    <span>تحویل کلید</span>

                                                                    <div class="progressbar-tooltip">
                                                                        <span>کلید در محل آدرس اقامتگاه توسط هماهنگ‌کننده به شما تحویل داده خواهد شد</span>
                                                                    </div>
                                                                </span>
                                                            </li>

                                                        @elseif($trip->status == 2)
                                                            <li class="deactive">
                                                                <span class="progressbar-wrapper">ثبت درخواست
                                                                    {{--<div class="progressbar-tooltip">--}}
                                                                        {{--<span>درخواست شما ثبت گردید و در حال پیگیری است</span>--}}
                                                                    {{--</div>--}}
                                                                </span>
                                                            </li>

                                                            <li class="deactive">
                                                                <span class="progressbar-wrapper">
                                                                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                    <span>رد توسط میزبان</span>

                                                                    <div class="progressbar-tooltip">
                                                                        <span>درخواست شما توسط میزبان رد شد. با جستجو ویلاهای مشابه، اقامتگاه مناسب رو انتخاب نمایید</span>
                                                                    </div>
                                                                </span>
                                                            </li>

                                                            <li>
                                                                <span class="progressbar-wrapper">                                                            پیش‌پرداخت
                                                                    {{--<div class="progressbar-tooltip">--}}
                                                                        {{--<span>با انجام پیش‌پرداخت، درخواست خود را نهایی فرمایید</span>--}}
                                                                    {{--</div>--}}
                                                                </span>
                                                            </li>

                                                            <li>
                                                                <span class="progressbar-wrapper">تحویل کلید
                                                                    {{--<div class="progressbar-tooltip">--}}
                                                                        {{--<span>کلید اقامتگاه را در محل تحویل بگیرید</span>--}}
                                                                    {{--</div>--}}
                                                                </span>
                                                            </li>

                                                        @elseif($trip->status == 3)
                                                            @if(time() > $trip->checkout+(24*60*60))
                                                                <li class="active">
                                                                    <span class="progressbar-wrapper">ثبت درخواست
                                                                        {{--<div class="progressbar-tooltip">--}}
                                                                        {{--<span>درخواست شما ثبت گردید و در حال پیگیری است</span>--}}
                                                                        {{--</div>--}}
                                                                    </span>
                                                                </li>

                                                                <li class="active">
                                                                    <span class="progressbar-wrapper">تایید میزبان
                                                                        {{--<div class="progressbar-tooltip">--}}
                                                                        {{--<span>مالک بازه‌ی شما را تایید نکرده است</span>--}}
                                                                        {{--</div>--}}
                                                                    </span>
                                                                </li>

                                                                <li class="active">
                                                                    <span class="progressbar-wrapper">
                                                                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                        <span>پیش‌پرداخت</span>

                                                                        <div class="progressbar-tooltip">
                                                                            <span>پرداخت شما با موفقیت انجام شد. سفر خوبی داشته باشید</span>
                                                                        </div>
                                                                    </span>
                                                                </li>

                                                                <li class="active">
                                                                    <span class="progressbar-wrapper">
                                                                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                        <span>تحویل کلید</span>

                                                                        <div class="progressbar-tooltip">
                                                                            <span>کلید در محل آدرس اقامتگاه توسط هماهنگ‌کننده به شما تحویل داده خواهد شد</span>
                                                                        </div>
                                                                    </span>
                                                                </li>
                                                            @else
                                                                <li class="active">
                                                                    <span class="progressbar-wrapper">ثبت درخواست
                                                                        {{--<div class="progressbar-tooltip">--}}
                                                                            {{--<span>درخواست شما ثبت گردید و در حال پیگیری است</span>--}}
                                                                        {{--</div>--}}
                                                                    </span>
                                                                </li>

                                                                <li class="active">
                                                                    <span class="progressbar-wrapper">تایید میزبان
                                                                        {{--<div class="progressbar-tooltip">--}}
                                                                            {{--<span>مالک بازه‌ی شما را تایید نکرده است</span>--}}
                                                                        {{--</div>--}}
                                                                    </span>
                                                                </li>

                                                                <li class="active">
                                                                    <span class="progressbar-wrapper">
                                                                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                        <span>پیش‌پرداخت</span>

                                                                        <div class="progressbar-tooltip">
                                                                            <span>پرداخت شما با موفقیت انجام شد. سفر خوبی داشته باشید</span>
                                                                        </div>
                                                                    </span>
                                                                </li>

                                                                <li>
                                                                    <span class="progressbar-wrapper">
                                                                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                        <span>تحویل کلید</span>

                                                                        <div class="progressbar-tooltip">
                                                                            <span>کلید در محل آدرس اقامتگاه توسط هماهنگ‌کننده به شما تحویل داده خواهد شد</span>
                                                                        </div>
                                                                    </span>
                                                                </li>
                                                            @endif

                                                        @elseif($trip->status == 4)
                                                            <li class="deactive">
                                                                <span class="progressbar-wrapper">ثبت درخواست
                                                                    {{--<div class="progressbar-tooltip">--}}
                                                                        {{--<span>درخواست شما ثبت گردید و در حال پیگیری است</span>--}}
                                                                    {{--</div>--}}
                                                                </span>
                                                            </li>

                                                            <li class="deactive">
                                                            </li>

                                                            <li class="deactive">
                                                            </li>

                                                            <li class="deactive">
                                                                <span class="progressbar-wrapper">
                                                                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                    <span>منقضی شده</span>

                                                                    <div class="progressbar-tooltip">
                                                                        <span>مدت زمان اعتبار این درخواست تمام شده است</span>
                                                                    </div>
                                                                </span>
                                                            </li>

                                                        @elseif($trip->status == 5)
                                                            <li class="deactive">
                                                                <span class="progressbar-wrapper">ثبت درخواست
                                                                    {{--<div class="progressbar-tooltip">--}}
                                                                        {{--<span>درخواست شما ثبت گردید و در حال پیگیری است</span>--}}
                                                                    {{--</div>--}}
                                                                </span>
                                                            </li>

                                                            <li class="deactive">
                                                            </li>

                                                            <li class="deactive">
                                                            </li>

                                                            <li class="deactive">
                                                                <span class="progressbar-wrapper">
                                                                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                    <span>لغو توسط شما</span>

                                                                    <div class="progressbar-tooltip">
                                                                        <span>این درخواست توسط شما لغو شده است</span>
                                                                    </div>
                                                                </span>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                                <!-- End Step Bar -->
                                            </div>
                                            <!-- End Info Container -->
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                            @if($noItems_invoice_id)
                                <p class="panel-body" style="text-align: center">لیست شما خالی است.</p>
                            @endif
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    {{ $trips->links() }}
</div>

<script type="text/javascript" src="{{ asset('js/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/moment-jalaali.js') }}"></script>

<!-- Edit Review Checking -->
<?php if($trips[0])
    echo
        '<script>'.
            'var reviews = '.$trips[0]->guest->reviews.';'.
            'for(var i=0 ; i < reviews.length ; i++) {'.
                '$("#trips-btn-chat-"+reviews[i].reservation_id).css("display", "none");'.
                '$("#trips-btn-reviewNew-"+reviews[i].reservation_id).css("display", "none");'.
                '$("#trips-btn-reviewEdit-"+reviews[i].reservation_id).css("display", "").attr("href", "/reviews/"+reviews[i].id+"/edit");'.
            '}'.
        '</script>';
?>

<script type="text/javascript">
    //Convert to Persian Date
    $('.checkinR, .checkoutR').each(function() {
        $(this).text(digitsToHindi(moment.unix($(this).attr('value')).format("jYYYY/jMM/jDD")));
    });
    $('.myTrips-items-extraInfo .create-time').each(function() {
        $(this).text(digitsToHindi(moment($(this).attr('value'), 'YYYY/MM/DD HH:mm').format("HH:mm - jYYYY/jMM/jDD")));
    });

    //Show Confirm Message For New Reservation
    @if (session('status') == 'OK')
        $(document).ready(function(){
            alert('درخواست رزرو شما با موفقیت در سایت شب ثبت گردید. پس از اعلام وضعیت توسط میزبان، نتیجه درخواست از طریق پیامک به اطلاع شما خواهد رسید');
        });
    @endif

    //Bookmark request
    $('.item-favorite-container').click(function (e) {
        e.preventDefault();
        var bookmarked = parseInt($(this).attr('data-bookmarked'));
        var houseId = $(this).attr('data-houseid');
        var target = $('.item-favorite-container[data-houseid="'+houseId+'"]');

        if (bookmarked) {
            $.ajax({
                type: "POST",
                url: "/bookmarks/"+houseId+"/delete",
                success: function (data) {
                    if (data.status === 'success') {
                        target.find('.fa-heart').removeClass('active');
                        target.attr('data-bookmarked', '0')
                    }
                },
                error: function (data) {

                }
            });
        } else {
            $.ajax({
                type: "POST",
                url: "/houses/"+houseId+"/bookmark",
                success: function (data) {
                    if (data.status === 'success') {
                        target.find('.fa-heart').addClass('active');
                        target.attr('data-bookmarked', '1')
                    }
                },
                error: function (data) {

                }
            });
        }
    });

</script>


