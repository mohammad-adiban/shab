<div class="main-user">
    <div class="container room user-panel">
        <div class="col-xs-12 col-lg-10 col-lg-offset-1 padding-xs-0">
            <div class="row!!!">
                <!-- left sidebar -->
                <div class="col-sm-3 padding-xs-0">
                    <ul class="list-unstyled sidenav-list">
                        <li>
                            <a href="/houses" aria-selected="true" style="text-decoration: none" class="sidenav-item @if($currentRout == 'houses') {{'bold'}} @endif">آگهی‌های من</a>
                        </li>
                        <li>
                            <a href="/my_reservations" aria-selected="false" style="text-decoration: none; font-weight: 700" class="sidenav-item @if($currentRout == 'my_reservations') {{'bold'}} @endif">رزروهای من</a>
                        </li>

                        <div class="space-top-4 space-4">
                            <a href="/houses/new" aria-selected="false" style="font-weight: 500" class="btn btn-default"><lng key="user.newHouseButton"></lng></a>
                        </div>

                    </ul>
                </div>

                <div class="col-sm-9 padding-xs-0">
                    <div class="panel space-4">
                        <div class="panel-header">
                            لیست رزرو ها
                        </div>
                        <ul class="list-unstyled myhousesc col-xs-12 allTripsContainer" style="background-color: #fff;  border-top: none; padding: 5px 0 ;">
                            @if($reservations->isEmpty())
                                <p class="panel-body" style="text-align: center">لیست شما خالی است.</p>
                            @else
                                <?php $invoice_id = true; ?>
                                @foreach($reservations as $reserve)
                                    @if($reserve->invoice_id != null)
                                        <?php $invoice_id = false; ?>
                                        <li class="col-xs-12 col-sm-12 col-md-6 col-lg-6 myReservation-items">
                                            <div class="container col-xs-12 padding-xs-0;" style="padding: 0 6px">

                                                <div style="position: relative;">
                                                    <div style="display: flex; justify-content: space-between;">
                                                        <div style="position: relative; bottom: 25px">
                                                            <div style="display: inline-block; width: 60px; height: 60px; border-radius: 100%; border: 1px solid #c7c2c2; overflow: hidden;">
                                                                <img style="width: 100%; height: 100%" src="@if( $reserve->guest['picture'] != '') {{ $reserve->guest['picture'] }} @else /img/user-default.png @endif" />
                                                            </div>
                                                            <div style="display: inline-block; position: relative; bottom: 9px; font-size: 12px;">
                                                                {{ $reserve->guest['name'] }} {{ $reserve->guest['family'] }}
                                                            </div>

                                                            <div>
                                                                <a href="/houses/show/{{$reserve['house_id']}}" style="text-decoration: none; color: #555; font-weight: 500"><div>{{ $reserve->house['title'] }}</div></a>
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <div style="position: relative; top: 6px; display: flex; align-items: center; justify-content: center; min-width: 70px; height: 30px; padding: 0 3px;
                                                                border: 1px solid @if($reserve['status'] == 0 || $reserve['status'] == 1) #9a9a00 @elseif($reserve['status'] == 3) green @else #b10606 @endif;
                                                                color: @if($reserve['status'] == 0 || $reserve['status'] == 1) #9a9a00 @elseif($reserve['status'] == 3) green @else #b10606 @endif;
                                                                border-radius: 3px; text-align: center; cursor: default; font-weight: 500">
                                                                <span>
                                                                    @if($reserve['status'] == 0) منتظر تایید شما
                                                                    @elseif($reserve['status'] == 1)درانتظار پرداخت
                                                                    @elseif($reserve['status'] == 2) لغو شده توسط شما
                                                                    @elseif($reserve['status'] == 3)نهایی شده
                                                                    @elseif($reserve['status'] == 4) منقضی شده
                                                                    @elseif($reserve['status'] == 5)لغو شده توسط مهمان
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div>
                                                    <div style="display: flex; justify-content: space-between; align-items: center; font-size: 12px; margin-bottom: 5px">
                                                        <div style="text-align: center">
                                                            <div style="margin-bottom: 4px">تاریخ رفت</div>
                                                            <div class="checkinR" style="font-weight: 700" value="{{ $reserve['checkin'] }}"></div>
                                                        </div>

                                                        <div style="text-align: center">
                                                            <div style="margin-bottom: 4px">تاریخ برگشت</div>
                                                            <div class="checkoutR" style="font-weight: 700" value="{{ $reserve['checkout'] }}"></div>
                                                        </div>

                                                        <div style="text-align: center">
                                                            <div style="margin-bottom: 4px">تعداد نفرات</div>
                                                            <div style="font-weight: 700">{{ $reserve['guests'] }} نفر</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div style="border-top: 1px solid #d8d8d8">
                                                    <div style="display: flex; justify-content: space-between; padding: 5px; font-size: 12px; font-weight: 700">
                                                        <div>مبلغ نهایی</div>
                                                        <div>{{ $reserve->invoice['total_fee'] * 1000}} تومان</div>
                                                    </div>
                                                </div>

                                                <div>
                                                    <a href="/invoices/{{$reserve->invoice_id}}/show" target="_blank" style="text-decoration: none">
                                                        <div style="display: inline-block; border: 2px solid #bbb; padding: 6px 3px; margin: 15px 0 5px 0; text-align: center; color: #333; width: 48%; font-weight: 700; margin-left: 1%">
                                                            فاکتور
                                                        </div>
                                                    </a>
                                                    <a  href="/reservations/{{$reserve->id}}/show" target="_blank" style="text-decoration: none">
                                                        <div style="display: inline-block; border: 2px solid #bbb; padding: 6px 3px; margin: 15px 0 5px 0; text-align: center; color: #333; width: 48%; font-weight: 700">
                                                            گفتگو با مهمان
                                                        </div>
                                                    </a>
                                                </div>

                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                                @if($invoice_id)
                                    <p class="panel-body" style="text-align: center">لیست شما خالی است.</p>
                                @endif
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ asset('js/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/moment-jalaali.js') }}"></script>

<script type="text/javascript">
    $('.checkinR').each(function() {
        $(this).text(digitsToHindi(moment.unix($(this).attr('value')).format("jYYYY/jMM/jDD")));
    });
    $('.checkoutR').each(function() {
        $(this).text(digitsToHindi(moment.unix($(this).attr('value')).format("jYYYY/jMM/jDD")));
    });

</script>